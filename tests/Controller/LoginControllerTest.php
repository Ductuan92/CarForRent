<?php

namespace Tests\Controller;

use MyApp\Controller\LoginController;
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
        $_SESSION["userID"] = $param['id'];
        $session = new Session();
        $user = new User();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);

        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($loginService, $userLoginRequest, $userRequestValidation, $session);
        $result = $loginController->index();

        $this->assertEquals($expected, $result);
    }

    public function indexDataProvider()
    {
        return [
            'happy-case-1' => [
                'param' => [
                    'id' => '123'
                ],
                'expected' => true
            ],
            'unhappy-case-1' => [
                'param' => [
                    'id' => ''
                ],
                'expected' => false
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
        $_POST['userName'] = $param['userName'];
        $_POST['password'] = $param['password'];
//        $user->setUserName($param['userName']);
//        $user->setPassword($param['password']);
        $loginServiceMock = $this->getMockBuilder(LoginService::class)->disableOriginalConstructor()->getMock();
        $loginServiceMock->expects($this->once())->method('Login')->willReturn($user);

        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $session = new Session();
        $loginController = new LoginController($loginServiceMock, $userLoginRequest, $userRequestValidation, $session);

        $result = $loginController->login();

        $this->assertTrue($result);
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

        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($loginService, $userLoginRequest, $userRequestValidation, $session);
        $result = $loginController->login();

        $this->assertFalse($result);
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
        $session->setSessionId('3424');

        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        $loginController = new LoginController($loginService, $userLoginRequest, $userRequestValidation, $session);
        $loginController->logout();
        $expected = array_key_exists('userID', $_SESSION);

        $this->assertFalse($expected);
    }
}
