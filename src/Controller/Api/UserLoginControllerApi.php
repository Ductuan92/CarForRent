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
        parent::__construct($response, $request);
        $this->loginService = $loginService;
        $this->userLoginRequest = $userLoginRequest;
        $this->userRequestValidation = $userRequestValidation;
        $this->token = $token;
    }

    /**
     * @return Response
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
        $token = $this->token->generate($user);
        return $this->response->success([$token]);
    }

    /**
     * @return array
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
     * @return Response
     */
    public function logout(): Response
    {
        unset($_SESSION['userID']);
        $this->response->setReDirect('/user/login');
        return $this->response->view('/user/login');
    }
}
