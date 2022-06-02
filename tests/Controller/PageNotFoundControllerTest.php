<?php

namespace Tests\Controller;

use MyApp\Controller\PageNotFoundController;
use MyApp\Http\Request;
use MyApp\Http\Response;
use PHPUnit\Framework\TestCase;

class PageNotFoundControllerTest extends TestCase
{
    public function testPageNotFound()
    {
        $response = new Response();
        $request = new Request();
        $pageNotFoundController = new PageNotFoundController($request, $response);
        $param = $pageNotFoundController->PageNotFound();

        $result = $response->view('PageNotFound');
        $this->assertEquals($result, $param);
    }
}
