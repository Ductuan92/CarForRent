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

    public function testGetFormParams()
    {
        $_REQUEST['name'] = 'anh';
        $request = new Request();
        $result = $request->getFormParams()['name'];
        $this->assertEquals('anh', $result);
    }

    public function testGetFile()
    {
        $_FILES["fileToUpload"]["name"] = '1.png';
        $request = new Request();
        $result = $request->getFile()["fileToUpload"]["name"];
        $this->assertEquals('1.png', $result);
    }
    /**
     * @dataProvider getParamsDataProvider
     * @return void
     */
    public function testGetParams($param, $expected)
    {
        $_SERVER['REQUEST_URI'] = $param['REQUEST_URI'];
        $request = new Request();
        $result = $request->getParams();
        $this->assertEquals($expected, $result);
    }

    public function getParamsDataProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>[
                  'REQUEST_URI'=>'/api/cars?brand=Mercedes AMG&price=500 000 USD&description=only one'
              ],
              'expected'=>[
                  'brand'=>'Mercedes AMG',
                  'price'=>'500 000 USD',
                  'description'=>'only one'
              ]
          ]
        ];
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
                'param'=> '/login',
                'expected'=> '/login'
            ]
        ];
    }
}
