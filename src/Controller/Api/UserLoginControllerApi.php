<?php

namespace MyApp\Controller\Api;

use MyApp\Exception\AuthenticationException;
use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\request\UserLoginRequest;
use MyApp\service\LoginService;
use MyApp\service\TokenService;
use MyApp\Validation\UserRequestValidation;

class UserLoginControllerApi extends AbstractControllerApi
{
    private LoginService $loginService;
    private UserLoginRequest $userLoginRequest;
    private UserRequestValidation $userRequestValidation;
    private Response $response;
    private Request $request;
    private TokenService $token;

    /**
     * @param LoginService $loginService
     */
    public function __construct(
        LoginService $loginService,
        UserLoginRequest $userLoginRequest,
        UserRequestValidation $userRequestValidation,
        Response $response,
        Request $request,
        TokenService $token,
    )
    {
        $this->loginService = $loginService;
        $this->userLoginRequest = $userLoginRequest;
        $this->userRequestValidation = $userRequestValidation;
        $this->token = $token;
        $this->response = $response;
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function index(): bool
    {

    }

    /**
     * @return bool
     * @throws \ReflectionException
     */
    public function login(): Response
    {
        $params = $this->request->getParams();
        $this->userLoginRequest->setUserName($params['username']);
        $this->userLoginRequest->setPassword($params['password']);
        if(!empty($this->checkUserRequest())){
            return $this->response->error([$this->checkUserRequest()]);
        }
        $user = $this->loginService->Login($this->userLoginRequest);
        if ($user == null) {
            return $this->response->error(["username or password is incorrect"]);
        }
        $this->response->setHeaders(['']);
        $token = $this->token->generate($user);
        return $this->response->success([$token]);
    }

    /**
     * @return string[]|void
     */
    private function checkUserRequest(): array
    {
        $message = $this->userRequestValidation->validateEmptyUserNamePassword($this->userLoginRequest);
        if ($message != []) {
            return ($message);
        }
        return [];
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
