<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
use App\Services\UserService;

class UserController extends Controller {

    protected $auth;
    protected $user;
    public function __construct(JWTAuth $auth, UserService $user) {
        $this->auth = $auth;
        $this->user = $user;
    }


    public function logout() {
        $token = JWTAuth::getToken();
        JWTAuth::invalidate($token);

        return response()->json(null,200);
    }

    public function update(Request $request) {
        $user = $this->user->loggedInUser();
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


    public function updatePassword(Request $request) {
        $user = $this->user->loggedInUser();
        if($user) {
            $validate = $request->validate([
                'password' => 'required|min:5'
            ]);

            if($validate ) {
                if(\Hash::check($request->old_password, $user->password)) {
                    $user->password = Hash::make($request->password);
                    $user->save();
                    return response()->json([
                        'meta' => [
                            'message'=> "User password updated",
                        ],
                        "data" => [
                            "user" => true
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

    public function verifyEmail($id,$token,$date) {
        $created = date("Y-m-d H:i:s", $date);

        $user = User::where('id', $id)
                ->where('verify_token', $token)
                ->where('created_at', $created)->first();
        if($user) {
            $user->email_verified = true;
            $user->save();

            return response()->json([
                'data' => [
                    'success' => true
                ]
            ]);
        }

        return response()->json([
            'data' => [
                'success' => false
            ]
        ]);
    }

}
