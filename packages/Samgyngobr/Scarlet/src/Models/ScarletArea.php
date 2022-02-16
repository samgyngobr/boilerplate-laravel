<?php

namespace Samgyngobr\Scarlet\Models;

use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ScarletArea extends Model
{
    use HasFactory;


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    protected $table    = 'sk_area';
    protected $area     = null;
    protected $fillable = [
        'name', 'label', 'url', 'multiple', 'status', 'gallery', 'id_sk_area'
    ];


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function set( $area = null )
    {
        if( $area && $area != null )
        {
            if( is_string( $area ) )
                $res = ScarletArea::where('url', $area)->first();
            else
                $res = ScarletArea::where('id', $area)->first();

            if( !$res )
                throw new Exception( __( 'scarlet.area_not_found' ), 002 );

            $this->area = $res->id;
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public function details()
    {
        return ScarletArea::where( 'id', $this->area )->first();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function list( $query = '' )
    {
        return DB::select("SELECT * FROM sk_area {$query} ");
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function new( Request $post )
    {
        $url     = Str::slug($post->name, '-');
        $hasArea = ScarletArea::where('url', $url)->first();

        if($hasArea)
            throw new Exception( __('scarlet.title_invalid'), 1 );

        DB::beginTransaction();

        try
        {
            $fields = json_decode( $post->json, true );

            $areaId = ScarletArea::create([
                'name'     => $url,
                'label'    => $post->name,
                'multiple' => $post->multiple,
                'gallery'  => $post->gallery,
                'area_id'  => ( $post->area != '' ) ? $post->area : null,
                'url'      => $url
            ]);

            $versionId = ScarletVersion::create([
                'id_sk_area' => $areaId->id,
                'active'     => 1
            ]);

            foreach ($fields as $key => $value)
            {
                $ar = [];

                foreach ($value as $k => $v)
                    $ar[ $v['name'] ] = $v['value'];

                $fieldId = ScarletField::create([
                    'id_sk_version' => $versionId->id,
                    'name'          => Str::slug($ar['field'], '-'),
                    'label'         => $ar['field'],
                    'type'          => $ar['type'],
                    'required'      => $ar['required'],
                    'order'         => ( $ar['order'] ) ? $ar['order']: 0,
                    'index'         => $ar['index'],
                ]);

                foreach ($ar as $ke => $va)
                {
                    $posA = strpos( $ke, 'label[' );
                    $posB = strpos( $ke, ']' );

                    if( $posA !== false && $posB !== false )
                    {
                        $val = substr( $ke, $posA+6, $posB-($posA+6) );

                        ScarletFieldOptions::create([
                            'id_sk_field' => $fieldId->id,
                            'name'        => $va,
                            'value'       => $ar[ 'value[' . $val . ']' ]
                        ]);
                    }
                }

            } // foreach ($fields as $key => $value)

            DB::commit();

            return true;
        }
        catch (\Exception $ex)
        {
            DB::rollback();
            throw $ex;
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function edit( Request $post, $id )
    {
        try
        {
            DB::beginTransaction();

            $fields = json_decode( $post->json, true );

            $sa           = ScarletArea::where( 'id', $id )->first();
            $sa->label    = $post->name;
            $sa->multiple = $post->multiple;
            $sa->gallery  = $post->gallery;
            $sa->save();

            DB::update('UPDATE sk_version SET active=0 WHERE id_sk_area = ?', [ $id ]);

            $versionId = ScarletVersion::create([
                'id_sk_area' => $id,
                'active'     => 1
            ]);

            foreach ($fields as $key => $value)
            {
                $ar = [];

                foreach ($value as $k => $v)
                    $ar[ $v['name'] ] = $v['value'];

                $fieldId = ScarletField::create([
                    'id_sk_version' => $versionId->id,
                    'name'          => Str::slug( $ar['field'], '-' ),
                    'label'         => $ar['field'],
                    'type'          => $ar['type'],
                    'required'      => $ar['required'],
                    'order'         => ( $ar['order'] ) ? $ar['order']: 0,
                    'index'         => $ar['index'],
                ]);

                foreach ($ar as $ke => $va)
                {
                    $posA = strpos( $ke, 'label[' );
                    $posB = strpos( $ke, ']' );

                    if( $posA !== false && $posB !== false )
                    {
                        $val = substr( $ke, $posA+6, $posB-($posA+6) );

                        ScarletFieldOptions::create([
                            'id_sk_field' => $fieldId->id,
                            'name'        => $va,
                            'value'       => $ar[ 'value[' . $val . ']' ]
                        ]);
                    }
                }

            } // foreach ($fields as $key => $value)

            DB::commit();

            return true;
        }
        catch (\Exception $ex)
        {
            DB::rollback();
            throw $ex;
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
