<?php

namespace Tests\Controller\Api;

use MyApp\Controller\Api\UserLoginControllerApi;
use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\model\Token;
use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\request\UserLoginRequest;
use MyApp\service\LoginService;
use MyApp\service\TokenService;
use MyApp\Validation\UserRequestValidation;
use PHPUnit\Framework\TestCase;

class UserLoginControllerApiTest extends TestCase
{
    /**
     * @dataProvider loginDataProvider
     * @return void
     */
    public function testLogin($param, $expected)
    {
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $userLoginControllerApi = $this->callLoginController();
        $result = $userLoginControllerApi->login();

        $this->assertEquals($expected, $result->getStatusCode());
    }

    public function loginDataProvider()
    {
        return [
        'happy-case-1' => [
                'param' => [
                    'method' => 'POST',
                    'uri' => '/api/user/login?username=anh&password=1234'
                ],
                'expected'=>Response::HTTP_STATUS_OK
            ],
            'unhappy-case-1' => [
                'param' => [
                    'method' => 'POST',
                    'uri' => '/api/user/login?username=anh&password=12345'
                ],
                'expected'=>Response::HTTP_STATUS_BAD_REQUEST
            ],
            'unhappy-case-2' => [
                'param' => [
                    'method' => 'POST',
                    'uri' => '/api/user/login?username=&password=12345'
                ],
                'expected'=>Response::HTTP_STATUS_BAD_REQUEST
            ],
        ];
    }

    public function testLogout()
    {
        $loginControllerApi = $this->callLoginController();
        $result = $loginControllerApi->logout();

        $response = new Response();
        $response->setReDirect('/user/login');
        $response->view('/user/login');
        $this->assertEquals($response, $result);
    }

    private function callLoginController()
    {
        $user = new User();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);
        $request = new Request();
        $response  = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $token = new TokenService();
        return new UserLoginControllerApi($loginService, $userLoginRequest, $userRequestValidation, $response, $request, $token);
    }
}
