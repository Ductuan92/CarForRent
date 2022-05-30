<?php

namespace MyApp\App;

use MyApp\Http\Request;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;
use MyApp\Http\Response;
use MyApp\Middleware\AclMiddleware;

class Application
{
    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function start()
    {
        $container = new Container();
        $routeConfig = $container->make(Route::class);
        $route = $routeConfig->getRoute();

        if($route == null){
            View::render('PageNotFound');
            return false;
        }
        $acl = $container->make(AclMiddleware::class);
        $acl->verify($route);

        $actionName = $route->getActionName();
        $controllerClassName = $route->getControllerClassName();
        $controller = $container->make($controllerClassName);
        $respond = $controller->$actionName();
        if($respond) {
            View::handle($respond);
        }
    }
}
