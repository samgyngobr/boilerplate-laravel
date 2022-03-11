<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Exception;
use App\Models\User;
use App\Repositories\UsersRepository;


class Profile extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin/profile/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator = Validator::make( $request->all(), [
            'name' => 'required|between:2,100',
        ]);

        if( $validator->fails() )
            return back()->withInput()->withErrors($validator);

        try
        {
            UsersRepository::edit( Auth::user()->id, $request );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Data updated successfully');
    }



    public function changePassword( Request $request )
    {
        $validator = Validator::make( $request->all(), [
            'old-pw'     => 'required|string|min:6',
            'new-pw'     => 'required|string|min:6',
            'confirm-pw' => 'required|string|min:6|same:new-pw',
        ]);

        if( $validator->fails() )
            return back()->withInput()->withErrors($validator);

        try
        {
            $req = $request->all();

            if ( ! Hash::check( $req['old-pw'], Auth::user()->password ) )
                throw new Exception("Current password id wrong", 1);

            UsersRepository::password( Auth::user()->id, $request->all() );
        }
        catch( Exception $e )
        {
            return back()->with('error', $e->getMessage());
        }

        return back()->with('success', 'Password updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }



}
