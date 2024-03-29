<?php

namespace Samgyngobr\Scarlet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScarletFieldOptions extends Model
{
    use HasFactory;


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    protected $table    = 'sk_field_options';
    protected $fillable = [ 'name', 'value', 'id_sk_field' ];


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


    public static function list( $id )
    {
        return ScarletFieldOptions::where( 'id_sk_field', $id )->get()->toArray();
    }


    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
