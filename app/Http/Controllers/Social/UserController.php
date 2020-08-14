<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use JWTAuth;
use Illuminate\Support\Facades\Hash;
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
        $resp='';
        $created = date("Y-m-d H:i:s", $date);
        @Todo Please check if diffrence is dates is less than 1 hour then activate else throw exception
        $user = User::where('id', $id)
                ->where('verify_token', $token)
                ->where('created_at', $created)->first();
        if($user) {
            $user->email_verified = true;
            $user->save();
            $resp=true;
            return View('front.success', ['resp'=> $resp]);
        }

        $resp=null;
        return View('front.success', ['resp'=> $resp]);
    }

}
