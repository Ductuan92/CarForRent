<?php

namespace Tests\Controller;

use MyApp\Controller\HomeController;
use PHPUnit\Framework\TestCase;

class HomeControllerTest extends TestCase
{
    public function testHomeController()
    {
        $homeController = new HomeController();
        $result = $homeController->index();
        $this->assertTrue($result);
    }
}
