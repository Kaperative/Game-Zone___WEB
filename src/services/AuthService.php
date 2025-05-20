<?php

namespace App\services;

use App\Core\Cookies\Cookies;
use App\Core\JsonWebToken\JsonWebToken;
use App\Models\User;


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

    private function infoUser(): array|false
    {
        $token=$this->cookies->get("ID");
        if(!empty($token))
        {

            $idUser = $this->jwt->validateToken($token);
            $result = $this->user->findById($idUser);

        }

        return $result ?? false;
    }

    public function isLogin(): bool
    {
        return !empty($this->infoUser());
    }

    public function getLogin(): string|false
    {
        $result = $this->infoUser();
        return $result['login']??false;

    }

    public function isAdmin(): bool
    {
        return ($this->infoUser()['isAdmin']?? false);
    }

    public function getId(): string|false
    {
        return $this->infoUser()['id'];
    }

    public function getEmail(): string|false
    {
        return $this->infoUser()['email'];
    }

    public function getDataCreated(): string|false
    {
        return date('Y-m-d', ($this->infoUser()['created_at']));

    }
}