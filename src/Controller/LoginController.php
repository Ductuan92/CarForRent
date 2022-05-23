<?php

namespace MyApp\Controller;

use MyApp\Database\Database;

use MyApp\request\UserLoginRequest;
use PDO;
use MyApp\App\View;
use MyApp\Repository\UserRepository;
use Exception;
use MyApp\App\Container;
use MyApp\Validation\UserLoginValidation;

class LoginController
{
    /**
     * @var PDO
     */
    protected PDO $connection;

    /**
     * @var Container
     */
    private Container $container;

    /**
     * @param $connection
     */
    public function __construct()
    {
        $this->connection = Database::databaseConnection();
        $this->container = new Container();
    }

    /**
     * @return void
     */
    public function index(): void
    {
        View::render('login');
        if (empty($_SESSION["userID"]))
            View::render('index');
        else
            View::render('login');
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function login(): void
    {
        $userRequest = $this->container->make(UserLoginRequest::class);
        $userTransfer = $userRequest->getUser();
        $_SESSION['userID'] = $userTransfer->getId();

        View::render('index');
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        View::render('login');
        session_unset();
        session_destroy();
    }
}
