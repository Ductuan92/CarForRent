<?php

namespace Tests\Http;

use MyApp\App\Route;
use MyApp\Http\Request;
use PHPUnit\Framework\TestCase;

class RequestTest extends TestCase
{
    /**
     * @dataProvider requestMethodDataProvider
     * @return void
     */
    public function testRequestMethod($param, $expected)
    {
        $route = new Route();
        $_SERVER['REQUEST_METHOD'] = $param;
        $request = new Request();
        $result = $request->requestMethod();
        $this->assertEquals($result, $expected);
    }

    public function requestMethodDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    'GET',
                    'POST',
                    'DELETE',
                    'PUT',
                    'OPTION'
                ],
                'expected'=>[
                    'GET',
                    'POST',
                    'DELETE',
                    'PUT',
                    'OPTION'
                ]
            ]
        ];
    }

    /**
     * @dataProvider requestUriDataProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testRequestUri($param, $expected)
    {
        $_SERVER['REQUEST_URI'] = $param;
        $request = new Request();
        $result = $request->requestUri();
        $this->assertEquals($result, $expected);
    }

    public function requestUriDataProvider(){
        return [
            'happy-case-1'=>[
                'param'=>[
                    '/login',
                    '/index',
                    '/user/login'
                ],
                'expected'=>[
                    '/login',
                    '/index',
                    '/user/login'
                ]
            ]
        ];
    }
}
