<?php

namespace MyApp\App;

use MyApp\Http\Request;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;

class Application
{
    /**
     * @return void
     * @throws \ReflectionException
     */
    public function start(): void
    {
        $container = new Container();

        #get route
        $route = $container->make(Route::class);
        $route->getRoute();

        #call controller with action
        $actionName = $route->getActionName();
        $controllerClassName = $route->getControllerClassName();
        $controller = $container->make($controllerClassName);
        $controller->$actionName();
    }
}
