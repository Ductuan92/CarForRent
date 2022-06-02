<?php

namespace Tests\Session;

use MyApp\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testGetSessionID()
    {
        $name = '123';
        $session = new Session();
        $session->setSessionName($name);
        $result = $session->getSessionName();
        $this->assertEquals($name, $result);
        $this->assertEquals($name, $result);
    }
}
