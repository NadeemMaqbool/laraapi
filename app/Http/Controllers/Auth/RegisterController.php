<?php

namespace App\Http\Controllers\Auth;

use App\Http\Requests\UserRegisterRequest;
use App\Mail\UserVerify;
use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Tymon\JWTAuth\JWTAuth;

class RegisterController extends Controller {
    //
    protected $auth;
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function register(UserRegisterRequest $request) {
        $random = Str::random(32);

       $user = User::create([
           'name' => $request->name,
           'username' => $request->username,
           'email' => $request->email,
           'country' => $request->country,
           'password' => bcrypt($request->password),
           'verify_token' => $random
       ]);

       $token = $this->auth->attempt($request->only('email', 'password'));
       if($user) {
           Mail::to($user->email)->send(new UserVerify($user));
       }
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
