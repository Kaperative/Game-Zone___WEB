<?php

namespace App\Core\Redirect;

use JetBrains\PhpStorm\NoReturn;

class Redirect
{
#[NoReturn] public function to(string $path): void
{
    header('Location: ' . $path);
    exit;
}
}