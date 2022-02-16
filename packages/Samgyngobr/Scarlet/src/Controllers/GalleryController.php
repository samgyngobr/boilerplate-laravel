<?php

namespace Samgyngobr\Scarlet\Controllers;

use Exception;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Samgyngobr\Scarlet\Models\Scarlet;

class GalleryController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( $url, $id )
    {
        $obj     = new Scarlet();
        $obj->setArea( $url );
        $gallery = $obj->galleryList( $id );
        $area    = $obj->getArea()->details();

        return View::make('samgyngobr.scarlet.gallery.index', compact( 'area', 'gallery', 'url', 'id' ) );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function new( Request $request, $url, $id )
    {
        try
        {
            if( !$request->hasFile('img') )
                throw new Exception( 'Erro' );

            $obj = new Scarlet();
            $obj->setArea( $url );
            $obj->galleryNew( $request->file('img'), $id );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Image saved successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function delete( Request $request, $url, $id, $did )
    {
        try
        {
            $obj = new Scarlet();
            $obj->setArea( $url );
            $obj->galleryDelete( $id, $did );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Image deleted successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////


}
