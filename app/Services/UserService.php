<?php


namespace App\Services;
use JWTAuth;

class UserService
{

    public function loggedInUser() {

        $token = JWTAuth::getToken();
        $user = JWTAuth::toUser($token);

        return $user;
    }

}
