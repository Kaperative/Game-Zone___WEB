<?php

namespace App\Core\Services;

use App\Core\DataBase\Model\User;
use App\Core\Cookies\Cookies;
use App\Core\JsonWebToken\JsonWebToken;


class AuthService
{
    private User $user;
    private Cookies $cookies;

    private JsonWebToken $jwt;

    public function __construct()
    {
        $this->cookies = new Cookies();
        $this->jwt = new JsonWebToken();
        $this->user = new User();
    }

    public function isLogin(): bool
    {
        $token=$this->cookies->get("ID");

        if(!empty($token))
        {
            $idUser = $this->jwt->validateToken($token);

            $result = $this->user->findById($idUser);

        }

        return !empty($result);
    }


}