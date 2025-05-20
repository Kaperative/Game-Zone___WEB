<?php

namespace App\Core\Http;

use App\Core\Validator\Validator;

class Request
{
        public array $get;

        public array $post;
        public array $server;
        public array $files;
        public array $cookies;

    public Validator $validator;
    public function __construct($_get, $_post, $_server, $_files, $_cookies)
    {
        $this->get=$_get;
        $this->post=$_post;
        $this->server=$_server;
        $this->files=$_files;
        $this->cookies=$_cookies;
        $this->validator = new Validator();
    }

    public static function createFromGlobals(): self
    {
        return new self($_GET, $_POST, $_SERVER, $_FILES, $_COOKIE);
    }

   public static function getUri():string
   {
       return strtok($_SERVER['REQUEST_URI'],"?");
   }

   public static function getMethod():string
   {
     return $_SERVER['REQUEST_METHOD'];
   }

   public function inputAll($name, $default = null): mixed
   {
        return $this->post[$name] ?? $this->get[$name] ?? $default;
   }

   public function inputGET($name, $default = null)
   {
       return $this->get[$name] ?? $default;
   }

   public function setGET($name, $value): void
   {
        $this->get[$name] = $value;
   }

   public function inputPOST($name, $default = null)
   {
       return $this->post[$name] ?? $default;
   }

    public function setValidator(Validator $validator): void
    {
        $this->validator = $validator;
    }


}