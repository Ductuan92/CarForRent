<?php

namespace Tests\model;

use MyApp\model\Token;
use PHPUnit\Framework\TestCase;

class TokenTest extends TestCase
{
    public function testGetId()
    {
        $token = new Token();
        $token->setId('123');
        $result = $token->getId();
        $this->assertEquals('123', $result);
    }
}
