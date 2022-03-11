<?php

namespace App\Repositories;

use Exception;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Mail\ForgotPassword;
use App\Interfaces\UsersRepositoryInterface;
use App\Models\User;

class UsersRepository extends BaseRepository implements UsersRepositoryInterface
{


    /**
     * StopRepository constructor.
     *
     * @param Users $model
     */
    public function __construct(Users $model)
    {
        parent::__construct($model);
    }




    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email'    => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
            throw new Exception( $validator->errors(), 422 );

        if (!$token = auth()->attempt($validator->validated()))
            throw new Exception( 'Erro ao tentar logar', 401 );

        return json_decode(auth()->user(), true);
    }



    public function insert(Request $request )
    {
        $insert = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        return $insert;
    }



    public function edit( $id, $attributes )
    {
        $reg = User::where( 'id', $id )->firstOrFail();
        $reg->name = $attributes->name;
        $reg->save();

        return $reg;
    }



    public function password( $id, $attributes )
    {
        $reg = User::where( 'id', $id )->firstOrFail();
        $reg->password = bcrypt( $attributes['new-pw'] );
        $reg->save();

        return $reg;
    }


    public function destroy( $id )
    {
        $reg = User::where( 'id', $id )->firstOrFail();
        $reg->delete();
    }


}
