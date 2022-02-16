<?php

namespace Samgyngobr\Scarlet\Controllers;

use Exception;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use Samgyngobr\Scarlet\Models\Scarlet;

class AdminController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index( $url )
    {
        $obj  = new Scarlet( $url );
        $area = $obj->getArea()->details(); //->toArray();

        if( $area->multiple == 1 )
        {
            $config = $obj->list();

            return View::make('samgyngobr.scarlet.admin.index', compact( 'area', 'config' ) );
        }
        else
        {
            $data   = $obj->uniqueData();
            $config = $obj->edit( $data['id'] );
            $id     = $data['id'];

            return View::make('samgyngobr.scarlet.admin.form', compact( 'area', 'config', 'url', 'id' ) );
        }
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Creating a new resource.
     *
     * @return Response
     */
    public function new( $url )
    {
        $obj    = new Scarlet( $url );
        $area   = $obj->getArea()->details(); //->toArray();
        $config = $obj->new();

        return View::make('samgyngobr.scarlet.admin.form', compact( 'area', 'config', 'url' ) );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function newSave( Request $request, $url )
    {
        try
        {
            $obj = new Scarlet( $url );
            $obj->saveNew( $request );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function unpublish($url, $id)
    {
        $obj = new Scarlet();
        $obj->unpublish( $id );

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function publish($url, $id)
    {
        $obj = new Scarlet();
        $obj->publish( $id );

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function edit( $url, $id )
    {
        $obj    = new Scarlet( $url );
        $area   = $obj->getArea()->details();
        $config = $obj->edit( $id );

        return View::make('samgyngobr.scarlet.admin.form', compact( 'area', 'config', 'url' ) );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function update( Request $request, $url, $id )
    {
        try
        {
            $obj = new Scarlet( $url );
            $obj->saveUpdate( $request, $id );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function updateUnique( Request $request, $url )
    {
        try
        {
            $obj = new Scarlet( $url );
            $obj->saveUpdateUnique( $request );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function delete( $url, $id )
    {
        try
        {
            $obj = new Scarlet( $url );
            $obj->deletePost( $id );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Post deleted successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////
}
