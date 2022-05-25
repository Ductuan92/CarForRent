<?php

namespace Tests\Controller;

use MyApp\Controller\PageNotFoundController;
use PHPUnit\Framework\TestCase;

class PageNotFoundControllerTest extends TestCase
{
    public function testPageNotFound()
    {
        $pageNotFoundController = new PageNotFoundController();
        $result = $pageNotFoundController->PageNotFound();
        $this->assertTrue($result);
    }
}
