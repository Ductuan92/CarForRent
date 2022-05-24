<?php

namespace Tests\Validation;

use MyApp\Validation\UserLoginVerify;
use PHPUnit\Framework\TestCase;

class UserLoginVerifyTest extends TestCase
{
    /**
     * @dataProvider verifyPasswordDataProvider
     * @return void
     */
    public function testVerifyPassword($param)
    {
        $verify = new UserLoginVerify();
        $result = $verify->verifyPassword($param['password'], $param['requestPassword']);
        $this->assertTrue($result);
    }

    /**
     * @dataProvider verifyPasswordDataProvider
     * @return void
     */
    public function testVerifyPasswordFalse($param)
    {
        $verify = new UserLoginVerify();
        $result = $verify->verifyPassword($param['password'], $param['requestPassword']);
        $this->assertFalse($result);
    }
    public function verifyPasswordDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=> [
                    'password'=>'$2y$10$.zX5e3Zi5L9WrOG0RVun4u/lB6WizDHN8qV69s2AySL/Cjy3sm7Wa',
                    'requestPassword'=>'1234'
                ]
            ],
            'happy-case-1'=>[
                'param'=> [
                    'password'=>'$2y$10$.zX5e3Zi5L9WrOG0RVun4u/lB6WizDHN8qV69s2AySL/Cjy3sm7Wa',
                    'requestPassword'=>'1234'
                ]
            ]
        ];
    }

    public function verifyPasswordFalseDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=> [
                    'password'=>'$2y$10$.zX5e3Zi5L9WrOG0RVun4u/lB6WizDHN8qV69s2AySL/Cjy3sm7Wa',
                    'requestPassword'=>'1234'
                ]
            ]
        ];
    }

}
