<?php

namespace Tests\Http;

use MyApp\Http\Response;
use PHPUnit\Framework\TestCase;

class ResponseTest extends TestCase
{
    public function testGetReDirect()
    {
        $response = new Response();
        $response->setReDirect('/login');
        $result = $response->getReDirect();
        $this->assertEquals($result, '/login');
    }

    public function testGetOption()
    {
        $response = new Response();
        $response->setOption(['error'=>'user not permitted']);
        $result = $response->getOption();
        $this->assertEquals(['error'=>'user not permitted'], $result);
    }

    public function testSuccess()
    {
        $response = new Response();
        $result = $response->success(['username'=>'anh'])->getData();
        $expected ='{"status":"success","data":{"username":"anh"}}';
        $this->assertEquals($expected, $result);
    }

    public function testError()
    {
        $response = new Response();
        $result = $response->error(['error'=>'file can not be empty'])->getData();
        $expected ='{"status":"error","data":{"error":"file can not be empty"}}';
        $this->assertEquals($expected, $result);
    }

    public function testGetTemplate()
    {
        $response = new Response();
        $response->setTemplate('login');
        $result = $response->getTemplate();
        $this->assertEquals('login', $result);
    }

    public function testGetHeader()
    {
        $response = new Response();
        $response->setHeaders(['Content-Type' => 'application/json']);
        $result = $response->getHeaders();
        $this->assertEquals(['Content-Type' => 'application/json'], $result);

    }

    public function testGetData()
    {
        $response = new Response();
        $response->setData("'username' => 'anh'");
        $result = $response->getData();
        $this->assertEquals("'username' => 'anh'", $result);

    }
}
