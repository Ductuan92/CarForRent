<?php

namespace Tests\service;

use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\request\UserLoginRequest;
use MyApp\service\LoginService;
use phpDocumentor\Reflection\Types\Nullable;
use PHPUnit\Framework\TestCase;

class LoginServiceTest extends TestCase
{
    /**
     * @dataProvider loginDataProvider
     * @param $param
     * @return void
     * @throws \ReflectionException
     */
    public function testLogin($param)
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);
        $user = new User();
        $userRepository = new UserRepository($user);

        $loginService = new LoginService($userRepository);
        $result = $loginService->Login($userRequest);
        $this->assertNotNull($result);
    }

    public function loginDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=>[
                    'userName'=> 'anh',
                    'password'=>'1234'
                ]
            ],
        ];
    }

    /**
     * @dataProvider loginFalseDataProvider
     * @param $param
     * @return void
     * @throws \ReflectionException
     */
    public function testLoginFalse($param)
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);
        $user = new User();
        $userRepository = new UserRepository($user);

        $loginService = new LoginService($userRepository);
        $result = $loginService->Login($userRequest);
        $this->assertNull($result);
    }

    public function loginFalseDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=>[
                    'userName'=> 'anh',
                    'password'=>'12345'
                ]
            ],
        ];
    }
}
