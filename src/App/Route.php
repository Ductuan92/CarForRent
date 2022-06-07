<?php

namespace MyApp\App;

use MyApp\Controller\Api\AdminLoginControllerApi;
use MyApp\Controller\Api\CarControllerApi;
use MyApp\Controller\Api\UserLoginControllerApi;
use MyApp\Controller\CarController;
use MyApp\Controller\HomeController;
use MyApp\Controller\LoginController;
use MyApp\Controller\PageNotFoundController;
use MyApp\Controller\AdminLoginController;
use MyApp\Http\Request;
use MyApp\model\User;

class Route
{
    const ROUTES = array(
        array('GET', '/', CarController::class, 'index', ''),
        array('GET', '/index', CarController::class, 'index', ''),
        array('GET', '/user/login', LoginController::class, 'index', ''),
        array('POST', '/user/login', LoginController::class, 'login', ''),
        array('POST', '/logout', LoginController::class, 'logout', ''),
        array('GET', '/logout', LoginController::class, 'login', ''),
        array('POST', '/cars', CarController::class, 'addCar', User::ROLE_ADMIN),
        array('GET', '/cars', CarController::class, 'addCarPage', ''),

        array('GET', '/api/cars', CarControllerApi::class, 'index', ''),
        array('POST', '/api/user/login', UserLoginControllerApi::class, 'login', ''),
        array('POST', '/api/cars', CarControllerApi::class, 'addCar', User::ROLE_ADMIN)
    );
    /**
     * @var string
     */
    protected string $role = '';
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
    protected string $controllerClassName = PageNotFoundController::class;

    /**
     * @var string
     */
    protected string $actionName = 'pageNotFound';

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
     * @return $this|null
     */
    public function getRoute(): Route|null
    {
        foreach (self::ROUTES as $route) {
            if ($route[0] === Request::requestMethod() && $route[1] === Request::requestUri()) {
                list($method, $uri, $controller, $action, $role) = $route;
                //echo $method. $uri. $controller. $action. $role;
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
        return $this->controllerClassName;
    }

    /**
     * @return string
     */
    public function getActionName(): string
    {
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
