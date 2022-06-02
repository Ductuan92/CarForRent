<?php

namespace MyApp\Controller;

use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\request\UserLoginRequest;
use MyApp\App\View;
use MyApp\service\LoginService;
use MyApp\Session\Session;
use MyApp\Validation\UserRequestValidation;

class LoginController extends AbstractController
{
    private LoginService $loginService;
    private UserLoginRequest $userLoginRequest;
    private UserRequestValidation $userRequestValidation;
    private Session $session;

    /**
     * @param LoginService $loginService
     */
    public function __construct(Request $request, Response $response,
        LoginService $loginService,
        UserLoginRequest $userLoginRequest,
        UserRequestValidation $userRequestValidation,
        Session $session,
    )
    {
        $this->loginService = $loginService;
        $this->userLoginRequest = $userLoginRequest;
        $this->userRequestValidation = $userRequestValidation;
        $this->session = $session;
        parent::__construct($request, $response);
    }
    /**
     * @return void
     */
    public function index(): Response
    {
        if (!empty($_SESSION["userName"])) {
            $this->response->setReDirect('/');
            return $this->response->view('index');
        }
        return $this->response->view('login');
    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function login(): Response
    {
        $message = $this->checkUserRequest();
        if($message != []){
            $this->response->setOption($message);
            return $this->response->view('login');
        }
        $user = $this->loginService->Login($this->userLoginRequest);
        if ($user == null) {
            $this->response->setOption(['error'=>'user or password is incorrect']);
            return $this->response->view('login');
        }
        $this->session->setSessionName($user->getUserName());
        $this->response->setReDirect('/');
        return $this->response->view('index');
    }

    /**
     * @return string[]
     */
    private function checkUserRequest(): array
    {
        $this->userLoginRequest->setUserName($_POST['userName']);
        $this->userLoginRequest->setPassword($_POST['password']);
        $message = $this->userRequestValidation->validateEmptyUserNamePassword($this->userLoginRequest);
        return $message;
    }

    /**
     * @return void
     */
    public function logout(): Response
    {
        unset($_SESSION['userName']);
        return $this->response->view('login');
    }
}
