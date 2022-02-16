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
        $file = uniqid() . "." . $img->getClientOriginalExtension();

        Image::open( $img->getPathname() )
            ->zoomCrop(250, 250)
            ->save( getcwd() . \Config::get('app.sk_file_path_thumbs') . $file );

        Image::open( $img->getPathname() )
            ->save( getcwd() . \Config::get('app.sk_file_path') . $file );

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
