<?php

namespace App\Core\Cookies;

class Cookies
{
    public function __construct()
    {

    }

    public function get(string $key) : ?string
    {
        return $_COOKIE[$key] ?? null;
    }

    public function set(string $key, $value, int $time) : void
    {
        setcookie($key, $value, time() + $time, "/");
    }

    public function delete(string $key) : void
    {
        setcookie($key, 0, time() -10, "/");
    }


}