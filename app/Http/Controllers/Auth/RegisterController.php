<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRegisterRequest;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller {
    //
    protected $auth;
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function register(UserRegisterRequest $request) {

       $user = User::create([
           'name' => $request->name,
           'username' => $request->username,
           'email' => $request->email,
           'country' => $request->country,
           'password' => bcrypt($request->password),

       ]);

       $token = $this->auth->attempt($request->only('email', 'password'));

       return response()->json([
                   'meta'=> [
                       'authenticated' => true,
                       'token' => $token
                    ],
                   'data' => [
                       'user' => $user
                   ]
               ], 200);
    }
}
