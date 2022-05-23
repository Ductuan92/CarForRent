<?php

namespace MyApp\App;

use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;
use MyApp\Http\Request;

class Route
{
    /**
     * @var string
     */
    protected string $method;

    /**
     * @var string
     */
    protected string $uri;

    /**
     * @var string
     */
    protected string $controllerClassName;

    /**
     * @var string
     */
    protected string $actionName;

    /**
     * @param string $method
     * @param string $uri
     * @param string $controllerClassName
     * @param string $actionName
     * @return void
     */
    private function setRoute(string $method, string $uri, string $controllerClassName, string $actionName): void
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controllerClassName = $controllerClassName;
        $this->actionName = $actionName;
    }

    /**
     * @return bool
     */
    public function getRoute(): bool
    {
        $routes = array(
            array('GET','/',HomeController::class,'index'),
            array('GET','/index',HomeController::class,'index'),
            array('GET','/user/login',LoginController::class,'index'),
            array('POST','/user/login',LoginController::class,'login'),
            array('POST','/logout',LoginController::class,'logout')
        );

        foreach ($routes as $route)
        {
            if($route[0] == Request::requestMethod() && $route[1] == Request::requestUri())
            {
                list($method, $uri, $controller, $action) = $route;
                $this->setRoute($method, $uri, $controller, $action);
            }
        }
        View::render('PageNotFound');
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * @return string
     */
    public function getControllerClassName(): string
    {
        return $this->controllerClassName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

}
