<?php

namespace MyApp\Controller;

use MyApp\request\UserLoginRequest;
use MyApp\App\View;
use MyApp\Repository\UserRepository;
use Exception;
use MyApp\service\LoginService;
use MyApp\Validation\UserLoginVerify;
use MyApp\Validation\UserRequestValidation;
use MyApp\model\User;

class LoginController
{
    private LoginService $loginService;
    private UserLoginRequest $userLoginRequest;
    private UserRequestValidation $userRequestValidation;

    /**
     * @param LoginService $loginService
     */
    public function __construct(
        LoginService $loginService,
        UserLoginRequest $userLoginRequest,
        UserRequestValidation $userRequestValidation
    )
    {
        $this->loginService = $loginService;
        $this->userLoginRequest = $userLoginRequest;
        $this->userRequestValidation = $userRequestValidation;
    }

    /**
     * @return void
     */
    public function index(): void
    {
        if (!empty($_SESSION["userID"]))
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
        //validate request
        $message = $this->userRequestValidation->validateEmptyUserNamePassword($this->userLoginRequest);
        if ($message != [])
            View::render('login', $message);

        $user = $this->loginService->Login($this->userLoginRequest);
        if ($user)
        {
            $_SESSION["userID"] = $user->getId();
            View::render('index');
        }
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        session_unset();
        session_destroy();
        View::render('login');
    }
}
