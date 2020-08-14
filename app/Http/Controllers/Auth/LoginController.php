<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\JWTAuth;

class LoginController extends Controller {
    //
    protected $auth;

    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function login(Request $request) {
        $login = $request->login;
        $field= filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field=>$login]);

        $credentials = $request->only($field, 'password');
        try {

            if(!$token = $this->auth->attempt($credentials)) {
                return response()->json([
                    'errors' => [
                        'root' => 'Wrong credentials. Please try again with correct one'
                    ]
                ], 401);
            }
        }catch (JWTException $e) {
            return response()->json([
                'errors' => [
                  'root' => $e->getMessage()
                ]
            ]. $e->getCode());
        }

        return response()->json([
            'meta' => [
                'authenticated' => "true",
                'token' => $token
            ],
            'data' => [
                'user' => $request->user(),
            ]
        ]);
    }
}
