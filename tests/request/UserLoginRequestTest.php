<?php

namespace Tests\request;

use MyApp\request\UserLoginRequest;
use PHPUnit\Framework\TestCase;

class UserLoginRequestTest extends TestCase
{
    public function testGetUserName()
    {
        $_POST['userName'] = 'an';
        $_POST['password'] = '12dsa';

        $userRequest = new UserLoginRequest();
        $result = $userRequest->getUserName();
        $this->assertEquals('an', $result);
    }

    public function testGetPassword()
    {
        $_POST['userName'] = 'an';
        $_POST['password'] = '12dsa';

        $userRequest = new UserLoginRequest();
        $result = $userRequest->getPassword();
        $this->assertEquals('12dsa', $result);
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
}
