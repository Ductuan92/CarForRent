<?php

namespace Tests\request;

use MyApp\request\UserLoginRequest;
use PHPUnit\Framework\TestCase;

class UserLoginRequestTest extends TestCase
{
    /**
     * @dataProvider UserRequestDataProvider
     * @return void
     */
    public function testGetUserName($param)
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);
        $result = $userRequest->getUserName();
        $this->assertEquals($param['userName'], $result);
    }

    /**
     * @dataProvider UserRequestDataProvider
     * @return void
     */
    public function testGetPassword($param)
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);
        $result = $userRequest->getPassword();
        $this->assertEquals($param['password'], $result);
    }

    public function testSetPassword()
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setPassword('sdasa');
        $result = $userRequest->getPassword();
        $this->assertEquals('sdasa', $result);
    }

    public function testSetUserName()
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName('banh');
        $result = $userRequest->getUserName();
        $this->assertEquals('banh', $result);
    }

    public function UserRequestDataProvider()
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
}
