<?php

namespace Samgyngobr\Scarlet\Controllers;

use Exception;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Validator;
use Config;

use Samgyngobr\Scarlet\Models\Scarlet;

class ConfigController extends Controller
{
    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $list = ( new Scarlet() )->listAreas();

        return view('samgyngobr.scarlet.config.list', compact('list'));
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $title  = 'New';
        $method = 'POST';
        $url    = Config::get('app.sk_url') . 'config';

        return view('samgyngobr.scarlet.config.form', compact('title', 'method', 'url') );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    // https://webartis-an.blogspot.com/2017/11/create-laravel-crud-in-laravel-55.html
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $post
     * @return Response
     */
    public function store( Request $post )
    {
        try
        {
            $v = Validator::make($post->all(),[
                'name'     => 'required|string',
                'gallery'  => 'integer|nullable',
                'multiple' => 'integer|nullable',
                'json'     => 'string',
            ]);

            if($v->passes())
            {
                ( new Scarlet() )->newArea( $post );
            }
            else
            {
                //this will return the errors & to check put "dd($errors);" in your blade(view)
                return back()->withErrors($v)->withInput();
            }
        }
        catch(Exception $e)
        {
            return back()->with('error', $e->getMessage() );
        }

        return back()->with('success','Post created success');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        $title  = 'Edit';
        $method = 'PUT';
        $url    = Config::get('app.sk_url') . "config/{$id}";
        $obj    = new Scarlet();
        $obj->setArea( $id );
        $post   = $obj->edtView();

        return view('samgyngobr.scarlet.config.form', compact('title', 'method', 'post', 'url') );
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request $post
     * @param  int  $id
     * @return Response
     */
    public function edit(Request $request, $id)
    {
        //die('edit');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    /**
     * Update the specified resource in storage.
     *
     * @param  string  $url
     * @return Response
     */
    public function update(Request $request, $url)
    {
        $v = Validator::make($request->all(),[
            'name'     => 'required|string',
            'gallery'  => 'integer|nullable',
            'multiple' => 'integer|nullable',
            'json'     => 'string',
        ]);

        if($v->passes())
        {
            $title   = 'Edit';
            $obj     = new Scarlet();
            $obj->setArea( $url );
            $obj->edtArea( $request );
        }
        else
        {
            //this will return the errors & to check put "dd($errors);" in your blade(view)
            return back()->withErrors($v)->withInput();
        }

        return back()->with('success','Post updated success');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function enable($url)
    {
        $obj = new Scarlet();
        $obj->setArea( $url );
        $obj->enableArea();

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

    public function disable($url)
    {
        $obj = new Scarlet();
        $obj->setArea( $url );
        $obj->disableArea();

        return back()->with('success', 'Post updated successfully');
    }

    /////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////////////////////

}
