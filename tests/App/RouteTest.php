<?php

namespace Tests\App;

use MyApp\App\Route;
use PHPUnit\Framework\TestCase;

class RouteTest extends TestCase
{
    /**
     * @dataProvider getRouteDataProvider
     * @return void
     */
    public function testGetRoute($param, $expected)
    {
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $route = new Route();
        $route->getRoute();
        $result=$route->getMethod();
        $this->assertEquals($result, $expected);
    }


    public function getRouteDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login'
                ],
                'expected'=>'POST'
            ],
            'happy-case-2'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/user/login'
                ],
                'expected'=>'GET'
            ]
        ];
    }

    /**
     * @dataProvider getUriDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testGetUri($param, $expected)
    {
        $_SERVER['REQUEST_METHOD'] = $param['method'];
        $_SERVER['REQUEST_URI'] = $param['uri'];
        $route = new Route();
        $route->getRoute();
        $result=$route->getUri();
        $this->assertEquals($result, $expected);
    }

    public function getUriDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    'method'=>'POST',
                    'uri'=>'/user/login'
                ],
                'expected'=>'/user/login'
            ],
            'happy-case-2'=>[
                'param'=>[
                    'method'=>'GET',
                    'uri'=>'/user/login'
                ],
                'expected'=>'/user/login'
            ]
        ];
    }
}
