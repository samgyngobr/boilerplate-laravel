<?php

namespace Samgyngobr\Scarlet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ScarletHistory extends Model
{

    use HasFactory;


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    protected $table = 'sk_history';

    protected $fillable = [
        'current', 'id_sk_data', 'id_sk_version'
    ];


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function tInput()
    {
        return array(
            '1' => 'sk_data_varchar',
            '2' => 'sk_data_integer',
            '3' => 'sk_data_decimal',
            '4' => 'sk_data_textarea',
            '5' => 'sk_data_varchar',
            '6' => 'sk_data_varchar',
            '7' => 'sk_data_varchar',
            '8' => 'sk_data_varchar',
            '9' => 'sk_data_varchar',
        );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getData( $config )
    {
        return ScarletHistory::where( 'id_sk_version', $config->id_sk_version )
            ->orderBy( 'created_at', 'DESC' )
            ->get();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getDataForm( $fields, $config )
    {
        $data = self::getData( $config );

        if( $data )
        {
            foreach ($fields as &$value)
            {
                $aux = DB::select( "SELECT * FROM {$this->tInput[ $value->type ]} WHERE id_sk_history=? AND id_sk_field=?", [
                    $data->id, $value->id
                ] )->first();

                if($aux)
                    $value->value = $aux->value;
                else
                    $value->value = '';
            }
        }

        return $fields;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function listBasic( $data_id, $version )
    {
        $tInput = self::tInput();
        $fields = ScarletField::getMainFields( $version );
        $ss     = '';

        foreach ($fields as $k => $v)
        {
            if( $k != count( $fields ) ) $ss .=', ';

            $ss .= " ( SELECT value FROM {$tInput[ $v['type'] ]} WHERE id_sk_history=sk_history.id AND id_sk_field={$v['id']} ) AS '{$v['name']}' ";
        }

        $ar = DB::select( "SELECT created_at AS last_update {$ss} FROM sk_history WHERE id_sk_data={$data_id} ORDER BY id DESC " );

        $arr = array_map(function($item) {
            return (array) $item;
        }, $ar );

        return $arr;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function insert( $arr )
    {
        DB::update( 'UPDATE sk_history SET current=0 WHERE id_sk_data = ?', [ $arr['data_id'] ] );

        DB::insert( 'INSERT INTO sk_history ( id_sk_version, id_sk_data, current, created_at, updated_at ) VALUES (?, ?, ?, NOW(), NOW() )', [
            $arr['version'], $arr['data_id'], 1
        ]);

        $idHistory = DB::getPdo()->lastInsertId();
        $tInput    = self::tInput();

        // save fields
        foreach ( $arr['fields'] as $key => $value )
        {
            // skip empty fields
            if( $arr['post'][ $value['name'] ] )
            {
                // is array?
                if( is_array( $arr['post'][ $value['name'] ] ) )
                {
                    foreach ( $arr['post'][ $value['name'] ] as $k => $v )
                    {
                        DB::insert("INSERT INTO {$tInput[ $value['type'] ]} ( id_sk_history, id_sk_field, value ) VALUES (?, ?, ?)", [
                            $idHistory, $value['id'], $v
                        ]);
                    }
                }
                else
                {
                    DB::insert("INSERT INTO {$tInput[ $value['type'] ]} ( id_sk_history, id_sk_field, value ) VALUES (?, ?, ?)", [
                        $idHistory, $value['id'], $arr['post'][ $value['name'] ]
                    ]);
                }
            }
        }
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getById( $data_id )
    {
        $hist = ScarletHistory::where( 'id_sk_data', $data_id )->orderBy( 'created_at', 'DESC' )->first();

        if($hist)
            $hist = $hist->toArray();

        return self::getList( $hist );
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getList( $hist )
    {
        /*
        SELECT * FROM sk_area;
        SELECT * FROM sk_field WHERE id_sk_area=1;
        SELECT * FROM sk_data  WHERE id_sk_area=1;

        SELECT
            * ,
            ( SELECT value FROM sk_data_varchar WHERE id_sk_history=sk_history.id AND id_sk_field=5 ) AS 'titulo' ,
            ( SELECT value FROM sk_data_varchar WHERE id_sk_history=sk_history.id AND id_sk_field=6 ) AS 'keywords' ,
            ( SELECT value FROM sk_data_varchar WHERE id_sk_history=sk_history.id AND id_sk_field=7 ) AS 'descricao' ,
            ( SELECT value FROM sk_data_textarea WHERE id_sk_history=sk_history.id AND id_sk_field=8 ) AS 'conteudo'
        FROM
            sk_history
        WHERE
            id_sk_data=1
        ORDER BY
            id DESC
        LIMIT
            1
        */

        if(!$hist)
            return null;

        $fields = ScarletField::getFields( $hist['id_sk_version'] );
        $ss     = '';
        $tInput = self::tInput();

        foreach ($fields as $k => $v)
        {
            if( $k != count( $fields ) )
                $ss .=', ';

            if( $v['type'] == 7 )
                $ss .= "( SELECT GROUP_CONCAT( value separator ';' ) FROM {$tInput[ $v['type'] ]} WHERE id_sk_history=sk_history.id AND id_sk_field={$v['id']} ) AS '{$v['name']}' ";
            else
                $ss .= "( SELECT value FROM {$tInput[ $v['type'] ]} WHERE id_sk_history=sk_history.id AND id_sk_field={$v['id']} ) AS '{$v['name']}' ";
        }

        $ar = DB::select( " SELECT sk_history.id {$ss} FROM sk_history WHERE id_sk_data={$hist['id_sk_data']} ORDER BY id DESC LIMIT 1 ");

        if( count($ar) > 0 )
            return (array) $ar[0];

        return null;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
