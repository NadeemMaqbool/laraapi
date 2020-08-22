<?php

namespace App\Http\Controllers\Social;

use App\Services\UserService;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\JWTAuth;

class FollowController extends Controller
{
    protected $auth;
    protected $user;
    public function __construct(JWTAuth $auth, UserService $user) {
        $this->auth = $auth;
        $this->user = $user;
    }
    public function toggleFollow($id) {
        $user = $this->auth->toUser($this->auth->getToken());

        $followUser = User::find($id);
        $user->toggleFollow($followUser);

        return response()->json([
            'followers' => $user->followings
        ]);
    }

    public function followers($id) {
        $user = User::find($id);

        if ($user) {
            return response()->json([
                'data' => [
                    'followers' => $user->followers
                ]
            ]);
        } else {
            return response()->json([
                'errors'=> [
                    'root' => "No user found"
                ]
            ]);
        }
    }

    public function iSFollowingEachOther($id) {
        $user = $this->auth->toUser($this->auth->getToken());
        $followedUser = User::find($id);

        return response()->json([
           "data" => $user->areFollowingEachOther($followedUser)
        ]);

    }
}
