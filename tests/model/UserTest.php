<?php

namespace Tests\model;
use MyApp\model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * @dataProvider userDataProvider
     * @return void
     */
    public function testGetId($param, $expected){
        $user = new User();
        $user->setId($param['id']);
        $result = $user->getId();
        $this->assertEquals($result,$expected['id']);
    }

    /**
     * @dataProvider userDataProvider
     * @return void
     */
    public function testGetUserName($param, $expected){
        $user = new User();
        $user->setUSerName($param['username']);
        $result = $user->getUserName();
        $this->assertEquals($result,$expected['username']);
    }

    /**
     * @dataProvider userDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testGetPassword($param, $expected){
        $user = new User();
        $user->setPassword($param['password']);
        $result = $user->getPassword();
        $this->assertEquals($result,$expected['password']);
    }

    /**
     * @dataProvider userDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testGetEmail($param, $expected){
        $user = new User();
        $user->setEmail($param['email']);
        $result = $user->getEmail();
        $this->assertEquals($result,$expected['email']);
    }

    /**
     * @dataProvider userDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testGetRole($param, $expected){
        $user = new User();
        $user->setRole($param['role']);
        $result = $user->getRole();
        $this->assertEquals($expected['role'], $result);
    }

    public function userDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=> [
                    'id'=>'1',
                    'username'=>'An',
                    'password'=>'dank',
                    'email'=>'an@gmail.com',
                    'role'=>'admin'
                ],
                'expected'=>[
                    'id'=>'1',
                    'username'=>'An',
                    'password'=>'dank',
                    'email'=>'an@gmail.com',
                    'role'=>'admin'
                ]
            ]
        ];
    }
}
