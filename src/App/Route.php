<?php

namespace MyApp\App;

use MyApp\Controller\Api\AdminLoginControllerApi;
use MyApp\Controller\Api\CarControllerApi;
use MyApp\Controller\Api\UserLoginControllerApi;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;
use MyApp\Controller\PageNotFoundController;
use MyApp\Controller\AdminLoginController;
use MyApp\Http\Request;
use MyApp\model\User;

class Route
{
    /**
     * @var string
     */
    protected string $role;
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
     * @param string $role
     * @return void
     */
    private function setRoute(string $method, string $uri, string $controllerClassName, string $actionName, string $role): void
    {
        $this->method = $method;
        $this->uri = $uri;
        $this->controllerClassName = $controllerClassName;
        $this->actionName = $actionName;
        $this->role = $role;
    }

    /**
     * @return bool
     */
    public function getRoute(): Route|null
    {
        $routes = array(
            array('GET', '/', HomeController::class, 'index', ''),
            array('GET', '/index', HomeController::class, 'index',''),
            array('GET', '/user/login', LoginController::class, 'index',''),
            array('POST', '/user/login', LoginController::class, 'login',''),
            array('POST', '/logout', LoginController::class, 'logout',''),
            array('GET', '/logout', LoginController::class, 'login',''),
            array('GET', '/admin/login', AdminLoginController::class, 'index',''),
            array('Post', '/admin/login', AdminLoginController::class, 'login',''),

            array('GET', '/api/admin/login', AdminLoginControllerApi::class, 'index',''),
            array('GET', '/api/cars', CarControllerApi::class, 'listAllCars',''),
            array('POST', '/api/user/login', UserLoginControllerApi::class, 'login',''),
            array('GET', '/api/user/cars', CarControllerApi::class, 'getCar',User::ROLE_ADMIN)
        );

        foreach ($routes as $route) {
            if ($route[0] == Request::requestMethod() && $route[1] == Request::requestUri()) {
                list($method, $uri, $controller, $action, $role) = $route;
                $this->setRoute($method, $uri, $controller, $action, $role);
                return $this;
            }
        }
        return null;
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
        if (empty($this->controllerClassName)) {
            $this->controllerClassName = PageNotFoundController::class;
        }
        return $this->controllerClassName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
        if (empty($this->actionName)) {
            $this->actionName = 'PageNotFound';
        }
        return $this->actionName;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

}
