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
     */
    public function testLogin($param)
    {
        $result = $this->createLogin($param);
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
     */
    public function testLoginFalse($param)
    {
        $result = $this->createLogin($param);
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

    /**
     * @param $param
     * @return User|null
     */
    private function createLogin($param): ?User
    {
        $user = new User();
        $userRequest = new UserLoginRequest();
        $userRepository = new UserRepository($user);
        $loginService = new LoginService($userRepository);

        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);
        return $loginService->Login($userRequest);
    }
}
