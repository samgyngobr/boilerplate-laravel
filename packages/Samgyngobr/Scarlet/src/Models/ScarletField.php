<?php

namespace Samgyngobr\Scarlet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Samgyngobr\Scarlet\Models\ScarletFieldOptions;
use stdClass;

class ScarletField extends Model
{
    use HasFactory;


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    protected $table = 'sk_field';

    protected $fillable = [
        'name', 'label', 'type', 'required', 'tip', 'additional', 'validation', 'order', 'index', 'id_sk_version'
    ];


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getFields( $version )
    {
        if(!$version) return new stdClass();

        $fields = ScarletField::where( 'id_sk_version', $version )
            ->orderBy( 'order', 'ASC' )
            ->get();

        foreach($fields as &$v)
            if( $v->type==5 or $v->type==6 or $v->type==7 )
                $v->options = ScarletFieldOptions::list( $v->id );

        return $fields;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function getMainFields( $version )
    {
        $fields = ScarletField::where( 'id_sk_version', $version )
            ->where( 'index', 1 )
            ->orderBy( 'order', 'ASC' )
            ->get()
            ->toArray();

        foreach( $fields as $v )
            if( $v['type']==5 or $v['type']==6 or $v['type']==7 )
                $v['options'] = ScarletFieldOptions::list( $v->id );

        return $fields;
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
