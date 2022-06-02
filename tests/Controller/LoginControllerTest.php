<?php

namespace Tests\Controller;

use MyApp\Controller\LoginController;
use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\service\LoginService;
use MyApp\Session\Session;
use PHPUnit\Framework\TestCase;
use MyApp\request\UserLoginRequest;
use MyApp\Validation\UserRequestValidation;

class LoginControllerTest extends TestCase
{
    /**
     * @dataProvider indexDataProvider
     * @return void
     */
    public function testIndex($param, $expected)
    {
        $_SESSION["userName"] = $param['userName'];
        $session = new Session();
        $user = new User();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);

        $request = new Request();
        $response = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($request, $response, $loginService, $userLoginRequest, $userRequestValidation, $session);
        $result = $loginController->index();
        var_dump($result);
        $this->assertEquals($expected, $result);
    }

    public function indexDataProvider()
    {
        $response = new Response();
        return [
//            'happy-case-1' => [
//                'param' => [
//                    'userName' => 'anh'
//                ],
//                'expected' => $response->view('index')
//            ],
            'unhappy-case-1' => [
                'param' => [
                    'userName' => ''
                ],
                'expected' => $response->view('login')
            ]
        ];
    }

    /**
     * @runInSeparateProcess
     * @dataProvider loginDataProvider
     * @return void
     * @throws \ReflectionException
     */
    public function testLogin($param): void
    {
        $user = new User();
        $user->setId($param['id']);
        $user->setUserName($param['userName']);
        $user->setPassword($param['password']);
        $_POST['userName'] = $param['userName'];
        $_POST['password'] = $param['password'];

        $loginServiceMock = $this->getMockBuilder(LoginService::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('Login')->willReturn($user);

        $request = new Request();
        $response = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $session = new Session();
        $loginController = new LoginController($request, $response, $loginServiceMock, $userLoginRequest, $userRequestValidation, $session);

        $result = $loginController->login();
        $expected = $response->view('index');
        $this->assertEquals($expected, $result);
    }

    public function loginDataProvider()
    {
        return [
            'happy-case-1' => [
                'param' => [
                    'id' => '1',
                    'userName' => 'anh',
                    'password' => '1234',
                    'method' => 'POST',
                    'uri' => '/user/login'
                ]
            ]
        ];
    }

    /**
     * @dataProvider loginFalseDataProvider
     * @return void
     * @throws \ReflectionException
     */
    public function testLoginFalse($param)
    {
        $_POST['userName'] = $param['userName'];
        $_POST['password'] = $param['password'];
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $user = new User();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);
        $session = new Session();

        $request = new Request();
        $response = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($request, $response, $loginService, $userLoginRequest, $userRequestValidation, $session);
        $result = $loginController->login();
        $expected = $response->view('index');
        $this->assertEquals($expected, $result);
    }

    public function loginFalseDataProvider()
    {
        return [
            'happy-case-1' => [
                'param' => [
                    'userName' => '',
                    'password' => '1234',
                    'method' => 'POST',
                    'uri' => '/user/login'
                ]
            ],
            'happy-case-2' => [
                'param' => [
                    'userName' => 'anh',
                    'password' => '12345',
                    'method' => 'POST',
                    'uri' => '/user/login'
                ]
            ]
        ];
    }

    /**
     * @runInSeparateProcess
     * @return void
     */
    public function testLogout()
    {

        $user = new User();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);
        $session = new Session();
        $session->setSessionName('3424');

        $request = new Request();
        $response  = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($request, $response, $loginService, $userLoginRequest, $userRequestValidation, $session);
        $result = $loginController->logout();

        $expected = $response->view('login');
        $this->assertEquals($expected, $result);
    }
}
