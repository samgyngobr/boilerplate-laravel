<?php

namespace Samgyngobr\Scarlet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;

class ScarletData extends Model
{

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    use HasFactory;

    protected $table    = 'sk_data';
    protected $fillable = [ 'url', 'deleted', 'published', 'id_sk_area' ];


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getData( $dataId, $published = false )
    {
        if( $published )
            $ret = ScarletData::where( 'id', $dataId )->where( 'published', 1 )->first();
        else
            $ret = ScarletData::where( 'id', $dataId )->first();

        if(!$ret)
            throw new Exception("Data not found!", 002);

        return $ret;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getListRaw( $area, $version, $published = false, $op = [] )
    {
        $st     = '';
        $limit  = '';
        $offset = '';

        if( $published )
            $st = ' AND published=1 ';

        if(isset($op['limit']))
            $limit = " LIMIT {$op['limit']} ";

        if(isset($op['offset']))
            $offset = " OFFSET {$op['offset']} ";

        return DB::select(
            " SELECT * FROM sk_data WHERE deleted=0 {$st} AND id_sk_area=:area_id {$limit} {$offset} ",
            [ 'area_id' => $area ]
        );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getCurrentData( $area )
    {
        return ScarletData::where( 'id_sk_area', $area )->where( 'published', 1 )->first();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getListBasic( $area, $version )
    {
        $list = ScarletData::where( 'deleted', 0 )->where( 'id_sk_area', $area )->get()->toArray();

        foreach ($list as $key => &$value)
        {
            $ar = ScarletHistory::listBasic( $value['id'], $version );

            if( count($ar) > 0 )
                $value['fields'] = $ar[0];
            else
                $value['fields'] = [];
        }

        return $list;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function new( $arr )
    {
        try
        {
            $url = '';

            foreach ($arr['fields'] as $key => $value)
                if( $value['index'] == 1 )
                    $url = Str::slug( $arr['post'][ $value['name'] ], '-' );

            $arr = self::validate( $arr );

            DB::beginTransaction();
            DB::insert("INSERT INTO sk_data (id_sk_area, url, created_at, updated_at ) VALUES (?, ?, NOW(), NOW())", [ $arr['area'], $url ]);

            $arr['data_id'] = DB::getPdo()->lastInsertId();

            ScarletHistory::insert( $arr );

            DB::commit();
        }
        catch(\Exception $e)
        {
            DB::rollBack();

            throw $e;
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function updatePost( $arr )
    {
        ScarletHistory::insert( self::validate( $arr, 'edit' ) );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function validate( $arr, $action = '' )
    {
        foreach ( $arr['fields'] as $key => $v )
        {
            switch ( $v['type'] )
            {
                case 1: $arr['post'][ $v['name'] ] = self::processText(     $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // text
                case 2: $arr['post'][ $v['name'] ] = self::processInteger(  $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // integer
                case 3: $arr['post'][ $v['name'] ] = self::processDouble(   $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // decimal
                case 4: $arr['post'][ $v['name'] ] = self::processTextArea( $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // textarea
                case 5: $arr['post'][ $v['name'] ] = self::processSelect(   $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // select
                case 6: $arr['post'][ $v['name'] ] = self::processRadio(    $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // radio
                case 7: $arr['post'][ $v['name'] ] = self::processCheckbox( $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null )          ); break; // checkbox
                case 8: $arr['post'][ $v['name'] ] = self::processImage(    $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null ), $action ); break; // image
                case 9: $arr['post'][ $v['name'] ] = self::processUpload(   $v, ( isset( $arr['post'][ $v['name'] ] ) ? $arr['post'][ $v['name'] ] : null ), $action ); break; // upload

            }
        }

        return $arr;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processText( $input, $post )
    {
        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processTextArea( $input, $post )
    {
        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processInteger( $input, $post )
    {
        $post = (integer) $post;

        if( $post AND !is_integer( $post ) )
            throw new Exception( __('scarlet.field_must_be', [ 'field' => $input['label'], 'type' => __('scarlet.integer') ] ), 1);

        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processDouble( $input, $post )
    {
        $post = (double) $post;

        if( $post AND ( !is_integer( $post ) and !is_double( $post ) ) )
            throw new Exception( __('scarlet.field_must_be', [ 'field' => $input['label'], 'type' => __('scarlet.double') ] ), 1);

        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processSelect( $input, $post )
    {
        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processRadio( $input, $post )
    {
        if( $input['required'] == 1 )
            throw new Exception( __('scarlet.field_required', [ 'field' => $input['label'] ] ), 1);

        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processCheckbox( $input, $post )
    {
        return $post;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processImage( $input, $post, $acao )
    {
        // na edição, não editar quando n informado
        if( $acao=='edit' and ( $post->get() == '' ) )
            return $input['value'];

        // item obrigatorio?
        if( $input['required'] and $post->get() == '' )
            throw new Exception( __('scarlet.field_required', [ 'field' => $input['label'] ] ), 1);

        if(!$post)
            return null;

        $post_array = (array) $post;
        $keys       = array_keys( $post_array );
        $filename   = $post_array[ $keys[1] ];

        $ext  = explode( '.', $filename );
        $file = uniqid() . '.' . $ext[ count( $ext )-1 ];

        $post->move( '.' . \Config::get('app.sk_file_path'), $file );

        return $file;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function processUpload( $input, $post, $acao )
    {
        // na edição, não editar quando n informado
        if( $acao=='edit' and ( !isset($post['tmp_name']) or $post['tmp_name'] == '' ) )
            return $input['value'];

        // item obrigatorio?
        if( $input['required'] and $post['tmp_name'] == '' )
            throw new Exception( __('scarlet.field_required', [ 'field' => $input['label'] ] ), 1);

        if(!$post)
            return null;

        $ext  = explode( '.', $post['name'] );
        $file = uniqid() . '.' . $ext[ count( $ext )-1 ];

        if ( !move_uploaded_file( $post['tmp_name'], '.' . \Config::get('app.sk_file_path') . $file ) )
            throw new Exception( __('scarlet.field_required', [ 'field' => $input['label'] ] ), 1);

        return $file;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getCurrent( $area )
    {
        $data = ScarletData::where( 'id_sk_area', $area )->where( 'published', 1 )->first();

        if(!$data)
        {
            try
            {
                DB::beginTransaction();
                DB::insert("INSERT INTO sk_data ( id_sk_area, url, published, created_at, updated_at ) VALUES (?, '', 1, NOW(), NOW())", [ $area ]);

                $data_id = DB::getPdo()->lastInsertId();
                $version = ScarletVersion::where( 'id_sk_area', $area )->first();

                DB::insert("INSERT INTO sk_history ( current, id_sk_data, id_sk_version, created_at, updated_at ) VALUES ( '1', ?, ?, NOW(), NOW() )", [ $data_id, $version->id ]);
                DB::commit();

                $data = ScarletData::where( 'id_sk_area', $area )->first();
            }
            catch(\Exception $e)
            {
                DB::rollBack();

                throw $e;
            }

        } // if(!$data)

        return $data->toArray();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function deletePost( $area, $id )
    {
        $reg = ScarletData::where( 'id_sk_area', $area )->where( 'id', $id )->first();
        $reg->deleted = 1;

        return $reg->save();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function search( $area, $version, array $op )
    {
        $whr    = [];
        $whrr   = '';
        $limit  = '';
        $offset = '';
        $order  = '';

        if(isset($op['where']))
            $whrr = self::genWhere( $op['where'] );

        if(isset($op['limit']))
            $limit = " LIMIT {$op['limit']} ";

        if(isset($op['offset']))
            $offset = " OFFSET {$op['offset']} ";

        if(isset($op['order']))
            $order = "
                ORDER BY
                  sk_data_integer.value {$op['order']},
                     sk_data_date.value {$op['order']},
                  sk_data_decimal.value {$op['order']},
                  sk_data_boolean.value {$op['order']},
                 sk_data_textarea.value {$op['order']},
                  sk_data_varchar.value {$op['order']}
            ";

        $sql ="

            SELECT
                sk_data.*
            FROM
                          sk_data
                LEFT JOIN sk_history       ON                     sk_data.id = sk_history.id_sk_data
                LEFT JOIN sk_version       ON       sk_history.id_sk_version = sk_version.id
                LEFT JOIN sk_field         ON         sk_field.id_sk_version = sk_version.id
                LEFT JOIN sk_data_integer  ON  sk_data_integer.id_sk_history = sk_history.id AND sk_field.`type` = 2
                LEFT JOIN sk_data_date     ON     sk_data_date.id_sk_history = sk_history.id AND sk_field.`type` = 10
                LEFT JOIN sk_data_decimal  ON  sk_data_decimal.id_sk_history = sk_history.id AND sk_field.`type` = 3
                LEFT JOIN sk_data_boolean  ON  sk_data_boolean.id_sk_history = sk_history.id AND sk_field.`type` = 11
                LEFT JOIN sk_data_textarea ON sk_data_textarea.id_sk_history = sk_history.id AND sk_field.`type` = 4
                LEFT JOIN sk_data_varchar  ON  sk_data_varchar.id_sk_history = sk_history.id AND sk_field.`type` in (1,5,6,7,8,9)
            WHERE
                    deleted=0
                AND sk_data.id_sk_area={$area}
                AND sk_history.current=1

                {$whrr}

            GROUP BY
                  sk_data.id
                , sk_data.url
                , sk_data.deleted
                , sk_data.published
                , sk_data.id_sk_area
                , sk_data.created_at
                , sk_data.updated_at
                , sk_data_integer.value
                , sk_data_date.value
                , sk_data_decimal.value
                , sk_data_boolean.value
                , sk_data_textarea.value
                , sk_data_varchar.value

            {$limit}
            {$offset}
            {$order}

        ";

        $list = DB::select( $sql );

        return $list;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    private static function genWhere( array $op )
    {
        $starr = [];

        foreach ($op as $key => $value)
        {
            $str = '';

            if( is_array( $value[0] ) )
            {
                $str .= '(';

                foreach ($value as $k => $v)
                    $str .= self::genWhere( [ $v ] );

                $str .= ')';
            }
            else
            {
                $v2   = ( isset( $value[2] ) ) ? $value[2] : '';
                $str .= self::genTxt( $value[0], $value[1], $v2 );
            }

            $starr[] = $str;
        }

        return implode('', $starr);
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    private static function genTxt( $field, $str, $op )
    {
        return "
            AND ( sk_field.name LIKE '{$field}' AND (
                    sk_data_integer.value LIKE '{$str}'
                OR     sk_data_date.value LIKE '{$str}'
                OR  sk_data_decimal.value LIKE '{$str}'
                OR  sk_data_boolean.value LIKE '{$str}'
                OR sk_data_textarea.value LIKE '{$str}'
                OR  sk_data_varchar.value LIKE '{$str}'
            ) {$op} )
        ";
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
