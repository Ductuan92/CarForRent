<?php

namespace Tests\Validation;
use MyApp\request\UserLoginRequest;
use MyApp\Validation\UserRequestValidation;
use PHPUnit\Framework\TestCase;

class UserRequestValidationTest extends TestCase
{
    /**
     * @dataProvider validateEmptyUserNamePasswordDataProvider
     * @return void
     */
    public function testValidateEmptyUserNamePassword($param, $expected)
    {
        $userRequest = new UserLoginRequest();
        $userRequest->setUserName($param['userName']);
        $userRequest->setPassword($param['password']);

        $userRequestValidation = new UserRequestValidation();
        $result = $userRequestValidation->validateEmptyUserNamePassword($userRequest);

        $this->assertEquals($result,$expected);
    }

    public function validateEmptyUserNamePasswordDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=> [
                    'userName'=>'asd',
                    'password'=>'sa'
                ],
                'expected'=>[]
            ],
            'happy-case-2'=>[
                'param'=> [
                    'userName'=>'',
                    'password'=>'sa'
                ],
                'expected'=>[
                    'error' => 'user name and password must not empty'
                ]
            ]
        ];
    }
}
