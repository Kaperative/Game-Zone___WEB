<?php

namespace App\Core\Config;

class Config
{
    public function getConfig(string $key) // key is types --- file.variable
    {
        [$file, $variable] = explode('.', $key);

        $path = APP_PATH.'/config/'.$file.'.php';

        if (!file_exists($path)) {
            return null;
        }

        $config= require $path;
        return $config[$variable]??null;
    }

    public function getAll(string $name): array
    {
       return  include APP_PATH.'/config/'.$name.'.php';

    }
}