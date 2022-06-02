<?php

namespace MyApp\App;

use MyApp\Controller\PageNotFoundController;
use MyApp\Database\Database;
use MyApp\Http\Request;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;
use MyApp\Http\Response;
use MyApp\Middleware\AclMiddleware;
use PDO;

class Application
{
    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function start(): bool
    {
        $controllerClassName = PageNotFoundController::class;
        $actionName = 'pageNotFound';

        $container = new Container();
        $routeConfig = $container->make(Route::class);
        $route = $routeConfig->getRoute();

        if($route){
            $actionName = $route->getActionName();
            $controllerClassName = $route->getControllerClassName();
            $acl = $container->make(AclMiddleware::class);
            $verify = $acl->verify($route);
            if(!$verify){
                return false;
            }
        }

        $controller = $container->make($controllerClassName);
        $response = $controller->{$actionName}();
        $view = $container->make(View::class);
        if($response) {
            $view->handle($response);
            return true;
        }
        return false;
    }

}
