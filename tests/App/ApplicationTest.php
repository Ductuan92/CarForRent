<?php

namespace Tests\App;

use MyApp\App\Application;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @dataProvider startDataProvider
     * @return void
     * @throws \ReflectionException
     */
    public function testStart($param)
    {
        $_SERVER['userId'] = '1';
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $app = new Application();
        $result = $app->start();
        $this->assertTrue($result);
    }

    public function startDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/'
                ],
            ],
            'happy-case-2'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/index'
                ],
            ],
            'happy-case-3'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/user/login'
                ],
            ],
            'happy-case-4'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login'
                ],
            ],
            'happy-case-6'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/logout'
                ],
            ],
            'happy-case-7'=>[
                'param'=>[
                    'method'=>'GETT',
                    'uri'=>'/user/login'
                ],
            ]
        ];
    }
}
