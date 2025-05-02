<?php

namespace App\Core\Session;

class Session
{
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

    }

    public function has($key): bool
    {
        return !empty($_SESSION[$key]);
    }


    public function getFlush($key)  // take value from session, and remove this value into this session
    {
        $value =$this->get($key);
        $this->delete($key);

        return $value;
    }

    public function set($key, $value):void
    {
        $_SESSION[$key] = $value;
    }

    public function get($key)
    {
        return $_SESSION[$key] ?? null;
    }

    public function delete($key):void
    {
        unset($_SESSION[$key]);
    }


    public function destroy():void
    {
        session_destroy();
    }
}