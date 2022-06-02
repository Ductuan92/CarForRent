<?php

namespace Tests\Controller;

use MyApp\Controller\HomeController;
use MyApp\Http\Request;
use MyApp\Http\Response;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomeController()
    {
        $request = new Request();
        $response = new Response();
        $homeController = new HomeController($request, $response);
        $result = $homeController->index();
        $expected = $response->view('index');
        $this->assertEquals($expected, $result);
    }
}
