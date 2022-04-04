<?php

namespace Samgyngobr\Scarlet\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Gregwar\Image\Image;

class ScarletGallery extends Model
{
    use HasFactory;

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    protected $table = 'sk_gallery';

    protected $fillable = [
        'img', 'legend', 'status', 'id_sk_data'
    ];

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public static function new( $img, $id )
    {
        $ext  = ( $img->getClientOriginalExtension() == 'png' ) ? 'png' : 'jpg';
        $file = uniqid() . "." . $ext;

        $aux  = implode( '/', array_filter( explode( '/', \Config::get('app.sk_file_path') ) ) );
        $res  = $img->storeAs( 'public/' . $aux, $file );

        asset('public/' . $aux . '/' . $file);

        Image::open( $img->getPathname() )
            ->zoomCrop(250, 250)
            ->save( public_path() . '/storage' . \Config::get('app.sk_file_path_thumbs') . $file, $ext );

        $gallery             = new ScarletGallery();
        $gallery->img        = $file;
        $gallery->legend     = '';
        $gallery->status     = true;
        $gallery->id_sk_data = $id;
        $gallery->save();
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public static function deleteImage( $id, $did )
    {
        return ScarletGallery::where( 'id_sk_data', $id )->where( 'id', $did )->delete();
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

}
