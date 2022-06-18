<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Response;

class AuthController extends Controller {

    public function register( Request $request ) {

        $validation = $request->validate( array(
            'name'     => 'required|string',
            'email'    => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed',
            'address'  => 'required',
            'phone'    => 'required',
        ) );

        $user = User::create( array(
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make( $request->password ),
            'address'  => $request->address,
            'phone'    => $request->phone,
        ) );

        $token = $user->createToken( 'myAppToken' )->plainTextToken;

        return Response::json( array(
            'message' => 'success',
            'user'    => $user,
            'token'   => $token,
        ), 200 );
    }

    public function login( Request $request ) {

        $validation = $request->validate( array(
            'email'    => 'required|string',
            'password' => 'required|string',
        ) );

        $user = User::where( 'email', $request->email )->first();

        if ( empty( $user ) || !Hash::check( $request->password, $user->password ) ) {
            return Response::json( array( 'message' => 'Credential does not match' ), 200 );
        }

        $token = $user->createToken( 'myAppToken' )->plainTextToken;

        return Response::json( array(
            'message' => 'success',
            'user'    => $user,
            'token'   => $token,
        ), 200 );
    }

    public function logout() {

        auth()->user()->tokens()->delete();

        return Response::json( array(
            'message' => 'Logout Success',
        ), 200 );
    }

}
