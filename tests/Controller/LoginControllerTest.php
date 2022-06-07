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
     * @dataProvider indexDataProvide
     * @return void
     */
    public function testIndex($param, $expected)
    {
        $response = new Response();
        $_SESSION["userName"] = $param['session'];
        $response->setReDirect($expected['redirect']);
        $response->view($expected['view']);

        $loginController = $this->callLoginController();
        $result = $loginController->index();
        $this->assertEquals($response, $result);
    }

    public function indexDataProvide()
    {
        return [
          'happy-case-1'=>[
              'param'=>[
                  'session' => 'anh'
              ],
              'expected' => [
                  'redirect'=>'/',
                  'view'=>'index'
              ]
          ],
            'unhappy-case-1'=>[
                'param'=>[
                    'session' => ''
                ],
                'expected' => [
                    'redirect'=>'',
                    'view'=>'login'
                ]
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
        $response = new Response();

        $loginController = $this->callLoginController($loginServiceMock);
        $result = $loginController->login();
        $response->setReDirect('/');
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
        $response = new Response();

        $loginController = $this->callLoginController();
        $result = $loginController->login();
        $expected = $response->view('login');
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
        $session = new Session();
        $session->setSessionName('3424');
        $response  = new Response();

        $loginController = $this->callLoginController();
        $result = $loginController->logout();

        $expected = $response->view('login');
        $this->assertEquals($expected, $result);
    }

    private function callLoginController($loginServiceMock = null)
    {
        $user = new User();
        $userRepository = new UserRepository($user);

        if($loginServiceMock)
        {
            $loginService = $loginServiceMock;
        } else{
            $loginService = new LoginService($userRepository);
        }

        $session = new Session();
        $request = new Request();
        $response  = new Response();
        $userLoginRequest = new UserLoginRequest();
        $userRequestValidation = new UserRequestValidation();
        return new LoginController($request, $response, $loginService, $userLoginRequest, $userRequestValidation, $session);
    }
}
