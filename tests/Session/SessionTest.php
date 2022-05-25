<?php

namespace Tests\Session;

use MyApp\Session\Session;
use PHPUnit\Framework\TestCase;

class SessionTest extends TestCase
{
    public function testGetSessionID()
    {
        $id = '123';
        $session = new Session();
        $session->setSessionId($id);
        $result = $session->getSessionId();
        $this->assertEquals($id, $result);
    }
}
