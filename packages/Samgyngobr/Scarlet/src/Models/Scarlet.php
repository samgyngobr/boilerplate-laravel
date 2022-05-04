<?php

namespace Samgyngobr\Scarlet\Models;

use Exception;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

use Samgyngobr\Scarlet\Models\ScarletArea;
use Samgyngobr\Scarlet\Models\ScarletVersion;

class Scarlet extends Model
{

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    private $oArea;

    private $area    = null;
    private $acao    = null;
    private $id      = null;

    private $fields  = null;
    public  $areaArr = null;
    public  $version = null;
    public  $error   = null;


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    /**
     * @param string $area Area key
     */
    public function __construct( $area = null )
    {
        if($area)
        {
            $this->area  = $area;
            $this->oArea = new ScarletArea();
            $this->oArea->set( $area );
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function listAreas()
    {
        return ScarletArea::get();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////



    public static function listEnabledAreas()
    {
        return ScarletArea::where('status', 1)->get();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function setArea( $area )
    {
        $this->area  = $area;
        $this->oArea = new ScarletArea();
        $this->oArea->set( $area );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function getArea()
    {
        return $this->oArea;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function newArea( Request $post )
    {
        return ScarletArea::new( $post );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function edtView()
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );
        $fields  = ScarletField::getFields( $version->id );
        $json    = [];

        foreach ( $fields as $key => $value )
        {
            $j = [
                [ 'name' => 'field'    , 'value' => $value->label    ],
                [ 'name' => 'required' , 'value' => $value->required ],
                [ 'name' => 'index'    , 'value' => $value->index    ],
                [ 'name' => 'order'    , 'value' => $value->order    ],
                [ 'name' => 'type'     , 'value' => $value->type     ],
                [ 'name' => 'name'     , 'value' => $value->name     ],
            ];

            if( $value->type == 8 )
            {
                $aux = json_decode( $value->additional, true );

                $j[] = [ 'name' => 'image_width' , 'value' => $aux['image_width' ] ];
                $j[] = [ 'name' => 'image_height', 'value' => $aux['image_height'] ];
            }

            if( isset($value->options) )
                foreach ($value->options as $k => $v)
                {
                    $j[] = [ 'name' => "label[$k]", 'value' => $v['name']  ];
                    $j[] = [ 'name' => "value[$k]", 'value' => $v['value'] ];
                }

            $json[] = $j;

        } // foreach ( $fields as $key => $value )

        $area->json = json_encode( $json );

        return $area;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function edtArea( $request )
    {
        $area = $this->oArea->details();

        ScarletArea::edit( $request, $area['id'] );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function enableArea()
    {
        $area = $this->oArea->details();
        $area->status = true;
        $area->save();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function disableArea()
    {
        $area = $this->oArea->details();
        $area->status = false;
        $area->save();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function new()
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );
        $fields  = ScarletField::getFields( $version->id );

        return array(
            'view'    => 'edit',
            'version' => $version->toArray(),
            'acao'    => 'novo',
            'area'    => $area->toArray(),
            'fields'  => $fields->toArray(),
        );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function list( $query = null )
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );

        return [
            'view'        => 'index',
            'area'        => $area->toArray(),
            'data'        => ScarletData::getListBasic( $area->id, $version->id ),
            'fieldLabels' => ScarletField::getMainFields( $version->id ),
        ];
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function saveNew( $request )
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );


        return ScarletData::new([
            'area'    => $area->id,
            'version' => $version->id,
            'fields'  => ScarletField::getFields( $version->id )->toArray(),
            'post'    => $request->all(),
        ]);
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function saveUpdate( $request, $id )
    {
        $area     = $this->oArea->details();
        $version  = ScarletVersion::getCurrent( $area->id );
        $data     = ScarletData::getData( $id );
        $currHist = ScarletHistory::getById( $data->id );
        $fields   = ScarletField::getFields( $version->id )->toArray();


        foreach ( $fields as $key => &$value )
            $value['value'] = $currHist[$value['name']];


        return ScarletData::updatePost([
            'area'    => $area->id,
            'version' => $version->id,
            'fields'  => $fields,
            'data_id' => $id,
            'post'    => $request->all(),
        ]);
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function saveUpdateUnique( $request )
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );
        $dt      = ScarletData::getCurrentData( $area->id );


        if(!$dt)
            throw new Exception(__('scarlet.data_not_found'), 002);


        $id       = $dt->id;
        $data     = ScarletData::getData( $id );
        $currHist = ScarletHistory::getById( $data->id );
        $fields   = ScarletField::getFields( $version->id )->toArray();


        foreach ( $fields as $key => &$value )
            if( isset( $currHist[$value['name']] ) )
                $value['value'] = $currHist[$value['name']];


        return ScarletData::updatePost([
            'area'    => $area->id,
            'version' => $version->id,
            'fields'  => $fields,
            'data_id' => $id,
            'post'    => $request->all(),
        ]);
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function unpublish( $id )
    {
        $cur = ScarletData::where( 'id', $id )->first();
        $cur->published = 0;
        $cur->save();

        return;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function publish( $id )
    {
        $cur = ScarletData::where( 'id', $id )->first();
        $cur->published = 1;
        $cur->save();

        return;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function edit( $id )
    {
        $area     = $this->oArea->details();
        $version  = ScarletVersion::getCurrent( $area->id );
        $data     = ScarletData::getData( $id );
        $fields   = ScarletField::getFields( $version->id );
        $currHist = ScarletHistory::getById( $data->id );


        foreach ($fields as $key => &$value)
            $value['value'] = ( isset( $currHist[ $value['name'] ] ) ) ? $currHist[ $value['name'] ] : null;


        return array(
            'view'    => 'edit',
            'data'    => $data,
            'version' => $version,
            'area'    => $area,
            'fields'  => $fields,
        );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function uniqueData()
    {
        $area = $this->oArea->details();

        return ScarletData::getCurrent( $area->id );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function deletePost( $id )
    {
        $area = $this->oArea->details();

        ScarletData::deletePost( $area->id, $id );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function fetchUnique()
    {
        $area     = $this->oArea->details();
        $data     = ScarletData::getCurrentData( $area->id );
        $version  = ScarletVersion::getCurrent( $area->id );
        $fields   = ScarletField::getFields( $version->id )->toArray();
        $currHist = ScarletHistory::getById( $data->id );
        $data     = $data->toArray();


        // if the current history data is not in the current version try to match
        foreach ($fields as $key => $value)
            $data[ $value['name'] ] = ( isset( $currHist[ $value['name'] ] ) ) ? $currHist[ $value['name'] ] : null;


        if( $area->gallery == 1 )
            $data['gallery'] = ScarletGallery::where('id_sk_data', $data['id'] )->get()->toArray();


        return $data;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function findById( $id )
    {
        $area     = $this->oArea->details();
        $version  = ScarletVersion::getCurrent( $area->id );
        $data     = ScarletData::getData( $id, true );
        $fields   = ScarletField::getFields( $version->id )->toArray();
        $currHist = ScarletHistory::getById( $data->id );
        $data     = $data->toArray();


        // if the current history data is not in the current version try to match
        foreach ($fields as $key => &$value)
            $data[ $value['name'] ] = ( isset( $currHist[ $value['name'] ] ) ) ? $currHist[ $value['name'] ] : null;


        if( $area->gallery == 1 )
            $data['gallery'] = ScarletGallery::where('id_sk_data', $data['id'] )->get()->toArray();


        return $data;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function fetch( $op = [] )
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );
        $data    = ScarletData::getListRaw( $area->id, $version->id, true, $op );
        $fields  = ScarletField::getFields( $version->id )->toArray();


        foreach ($data as $k => &$v)
        {
            $v        = (array) $v;
            $currHist = ScarletHistory::getById( $v['id'] );

            // if the current history data is not in the current version try to match
            foreach ($fields as $key => $value)
                $v[ $value['name'] ] = ( isset( $currHist[ $value['name'] ] ) ) ? $currHist[ $value['name'] ] : null;
        }

        return $data;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function search(array $op = [])
    {
        $area    = $this->oArea->details();
        $version = ScarletVersion::getCurrent( $area->id );
        $fields  = ScarletField::getFields( $version->id )->toArray();
        $data    = ScarletData::search( $area->id, $version->id, $op );


        foreach ($data as $k => &$v)
        {
            $v        = (array) $v;
            $currHist = ScarletHistory::getById( $v['id'] );

            // if the current history data is not in the current version try to match
            foreach ($fields as $key => $value)
                $v[ $value['name'] ] = ( isset( $currHist[ $value['name'] ] ) ) ? $currHist[ $value['name'] ] : null;
        }

        return $data;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function galleryList( $id )
    {
        $area = $this->oArea->details();
        $data = ScarletData::getData( $id );

        return ScarletGallery::where('id_sk_data', $data->id )->get();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function galleryNew( $img, $id )
    {
        $area = $this->oArea->details();
        $data = ScarletData::getData( $id );

        return ScarletGallery::new( $img, $id );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function galleryDelete( $id, $did )
    {
        $area = $this->oArea->details();
        $data = ScarletData::getData( $id );

        return ScarletGallery::deleteImage( $id, $did );
    }

    
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function saveUpload( $post )
    {
        $file = uniqid() . '.' . $post->getClientOriginalExtension();
        $aux  = implode( '/', array_filter( explode( '/', \Config::get('app.sk_file_path') ) ) );
        $res  = $post->storeAs( 'public/' . $aux, $file );

        return [
            'file' => $file,
            'path' => '/storage' . \Config::get('app.sk_file_path')
        ];
    }



    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

}
