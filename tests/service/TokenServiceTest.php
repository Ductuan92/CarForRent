<?php

namespace Tests\service;

use MyApp\Exception\AuthenticationException;
use MyApp\Exception\InvalidTokenException;
use MyApp\model\User;
use MyApp\service\TokenService;
use PHPUnit\Framework\TestCase;

class TokenServiceTest extends TestCase
{
    public function testGenerate()
    {
        $user = new User();
        $user->setId('2');
        $tokenSerVice = new TokenService();
        $token = $tokenSerVice->generate($user);
        $payload = $tokenSerVice->checkToken($token);
        $result = $payload['sub'];
        $this->assertEquals('2', $result);

        // check token payload
        $payload = $tokenSerVice->getTokenPayload('Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0aWQiOm51bGwsInN1YiI6IjEiLCJpYXQiOjE2NTQwNjUwMTR9.5TZugGVOi9TWFBmDUSJ6lqY560MW7r75nz5K2H5Hi_M');
        $result = $payload['sub'];
        $expected = '1';
        $this->assertEquals($result, $expected);

        $this->expectException(InvalidTokenException::class);
        $payload = $tokenSerVice->getTokenPayload('Bearer ');

        $this->expectException(AuthenticationException::class);
        $payload = $tokenSerVice->getTokenPayload('Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkpvaG4gRG9lIiwiaWF0IjoxNTE2MjM5MDIyfQ.');
    }
}
