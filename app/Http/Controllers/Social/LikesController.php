<?php

namespace App\Http\Controllers\Social;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Tymon\JWTAuth\JWTAuth;
use App\Post;

class LikesController extends Controller
{
    //
    protected $auth;
    protected $user;
    public function __construct(JWTAuth $auth, UserService $user) {
        $this->auth = $auth;
        $this->user = $user;
    }
    public function toggleLikes($id) {
        $user = $this->auth->toUser($this->auth->getToken());
        $post = Post::find($id);

        if($user) {
            if($post) {
                $user->toggleLike($post);

                return response()->json([
                    "likes" => $post->likers()->paginate(20)
                ]);
            } else {
                return response()->json([
                    "error"=> "Post does not exist anymore"
                ]);
            }
        } else {
            return response()->json([
                "error"=> "User not authorized"
            ]);
        }

    }

    public function getLikes($id) {
        $post = Post::find($id);

        if ($post) {
           return response()->json([
                "likes" => $post->likers()->count()
           ]);
        } else {
            return response()->json([
                "error"=> "Could not find the request post"
            ]);
        }
    }

}
