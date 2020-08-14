<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use JWTAuth;

class UserController extends Controller {

    protected $auth;
    public function __construct(JWTAuth $auth) {
        $this->auth = $auth;
    }

    public function user(Request  $request) {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        return response()->json(['code' => 200, 'data' => ['user' => $user]]);
    }

    public function logout() {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);

        return response()->json(null,200);
    }

    public function update(Request $request, $id) {
        $user = User::find($id);
        if($user) {
            if(!empty($request)) {
                $user->name = $request->name;
                $user->username = $request->username;
                $user->country = $request->country;
            }

            return response()->json([
                'meta' => [
                    'message'=> "User updated",
                ],
                "data" => [
                    "user" => $user
                ]
            ], 200);

        } else {
            return response()->json([
                "root" => [
                    "error" => "User does not exist"
                ]
            ]);
        }
    }


    public function updatePassword(Request $request, $id) {
        $user = User::find($id);
        if($user) {
            $validate = $request->validate([
                'password' => 'required|min:5'
            ]);

            if($validate ) {
                if(\Hash::check($user->password, $request->old_password)) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                    return response()->json([
                        'meta' => [
                            'message'=> "User password updated",
                        ],
                        "data" => [
                            "user" => $user
                        ]
                    ], 200);
                } else {
                    return response()->json([
                        'root' => [
                            'errors'=> "Please enter current correct password",
                        ]
                    ], 200);
                }

            }
            else {
                return response()->json([
                    'meta' => [
                        'message'=> $validate->errors(),
                    ],
                    "data" => [
                        null
                    ]
                ], 200);
            }


        } else {
            return response()->json([
                "root" => [
                    "error" => "User does not exist"
                ]
            ]);
        }
    }

}
