<?php 

namespace App\Core;

use App\Core\Container\Container;

class   App{

    public function run():void
    {
        $container =new  Container();
        // dd($request);
        $container->router->dispatch(
                $container->request->getUri(),
                $container->request->getMethod()
        );
    }
}