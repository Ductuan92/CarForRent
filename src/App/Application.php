<?php

namespace MyApp\App;

use MyApp\Http\Request;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;

class Application
{
    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function start(): bool
    {
        $container = new Container();
        $route = $container->make(Route::class);
        $route->getRoute();

        $actionName = $route->getActionName();
        $controllerClassName = $route->getControllerClassName();
        $controller = $container->make($controllerClassName);
        $controller->$actionName();
        return true;
    }
}
