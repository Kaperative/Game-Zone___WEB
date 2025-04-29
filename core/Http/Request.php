<?php

namespace App\Core\Http;

class Request
{
        private array $get;
        private array $post;
        private array $server;
        private array $files;
        private array $cookies;
    public function __construct($_get, $_post, $_server, $_files, $_cookies)
    {
        $this->get=$_get;
        $this->post=$_post;
        $this->server=$_server;
        $this->files=$_files;
        $this->cookies=$_cookies;
    }

    public static function createFromGlobals(): self
    {
        return new self($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

   public static function getUri():string
   {
       return strtok($_SERVER['REQUEST_URI'],"?");
   }

   public function getMethod():string
   {
     return $_SERVER['REQUEST_METHOD'];
   }

}