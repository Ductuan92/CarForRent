<?php

namespace Tests\App;

use MyApp\App\Application;
use MyApp\request\UserLoginRequest;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @dataProvider startDataProvider
     * @return void
     * @throws \ReflectionException
     */
    public function testStart($param)
    {
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $userRequest = new UserLoginRequest();
        $_POST['userName'] = $param['userName'];
        $_POST['password'] = $param['password'];
        $app = new Application();
        $result = $app->start();
        $this->assertTrue($result);
    }

    public function startDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-2'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/index',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-3'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-4'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-6'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/logout',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-7'=>[
                'param'=>[
                    'method'=>'GETT',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ],
            'happy-case-8'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login',
                    'userName' => '',
                    'password' => 'ada'
                ],
            ],
            'happy-case-9'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => '1234'
                ],
            ],
            'happy-case-10'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => ''
                ],
            ],
            'happy-case-11'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login',
                    'userName' => 'anh',
                    'password' => 'ada'
                ],
            ]
        ];
    }
}
