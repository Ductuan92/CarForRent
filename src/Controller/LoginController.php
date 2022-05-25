<?php

namespace MyApp\Controller;

use MyApp\request\UserLoginRequest;
use MyApp\App\View;
use MyApp\service\LoginService;
use MyApp\Session\Session;
use MyApp\Validation\UserRequestValidation;

class LoginController
{
    private LoginService $loginService;
    private UserLoginRequest $userLoginRequest;
    private UserRequestValidation $userRequestValidation;
    private Session $session;

    /**
     * @param LoginService $loginService
     */
    public function __construct(
        LoginService $loginService,
        UserLoginRequest $userLoginRequest,
        UserRequestValidation $userRequestValidation,
        Session $session
    )
    {
        $this->loginService = $loginService;
        $this->userLoginRequest = $userLoginRequest;
        $this->userRequestValidation = $userRequestValidation;
        $this->session = $session;
    }

    /**
     * @return void
     */
    public function index(): bool
    {
        if (!empty($_SESSION["userID"])){
            View::render('index');
            return true;
        }
        else {
            View::render('login');
            return false;
        }
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function login(): bool
    {
        //validate request
        $message = $this->userRequestValidation->validateEmptyUserNamePassword($this->userLoginRequest);
        if ($message == [])
        {
            View::render('login', $message);
            return false;
        }
        $user = $this->loginService->Login($this->userLoginRequest);
        if ($user == null){
            View::render('login',[
                'login'=>'user or password is incorrect'
            ]);
            return false;
        }
        else
        {
            $this->session->setSessionId($user->getId());
            View::render('index');
            echo $user->getUserName();
            return true;
        }
    }

    /**
     * @return void
     */
    public function logout(): void
    {
        unset($_SESSION['userID']);
        View::render('login');
        View::redirect('/user/login');
    }
}
