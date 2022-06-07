<?php

namespace MyApp\App;

use MyApp\Controller\PageNotFoundController;
use MyApp\Database\Database;
use MyApp\Http\Request;
use MyApp\Controller\LoginController;
use MyApp\Http\Response;
use MyApp\Middleware\AclMiddleware;
use PDO;

class Application
{
    private Container $container;

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function start(): bool
    {
        $this->container = new Container();
        list($controllerClassName, $actionName, $message) = $this->getController();

        $response = $this->callController($controllerClassName, $actionName);
        $view = $this->container->make(View::class);
        if($response) {
            $view->handle($response, $message ?? []);
            return true;
        }
        return false;
    }

    /**
     * @return array
     * @throws \ReflectionException
     */
    private function getController()
    {
        $controllerClassName = PageNotFoundController::class;
        $actionName = 'pageNotFound';

        $route = $this->getRoute();
        if($route != null) {
            $message = $this->checkAcl($route);
            $actionName = $route->getActionName();
            $controllerClassName = $route->getControllerClassName();
        }
        return [$controllerClassName, $actionName, $message];
    }

    /**
     * @param $controllerClassName
     * @param $actionName
     * @return mixed
     * @throws \ReflectionException
     */
    private function callController($controllerClassName, $actionName)
    {
        $controller = $this->container->make($controllerClassName);
        return $controller->{$actionName}();
    }

    /**
     * @return Route
     * @throws \ReflectionException
     */
    private function getRoute(): Route
    {
        $routeConfig = $this->container->make(Route::class);
        $route = $routeConfig->getRoute();
        return $route;
    }

    /**
     * @param $route
     * @return array
     * @throws \ReflectionException
     */
    private function checkAcl($route): array
    {
        $acl = $this->container->make(AclMiddleware::class);
        return $acl->verify($route);
    }
}
