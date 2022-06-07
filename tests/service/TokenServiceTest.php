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
    }

    /**
     * @return void
     * @throws AuthenticationException
     * @throws InvalidTokenException
     */
    public function testGetTokenPayload()
    {
        $tokenSerVice = new TokenService();
        $payload = $tokenSerVice->getTokenPayload('Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0aWQiOm51bGwsInN1YiI6IjEiLCJpYXQiOjE2NTQwNjUwMTR9.5TZugGVOi9TWFBmDUSJ6lqY560MW7r75nz5K2H5Hi_M');
        $result = $payload['sub'];
        $this->assertEquals('1', $result);
    }

    /**
     * @return void
     * @throws AuthenticationException
     * @throws InvalidTokenException
     */
    public function testGetTokenPayloadInvalidTokenException()
    {
        $this->expectException(InvalidTokenException::class);
        $tokenSerVice = new TokenService();
        $payload = $tokenSerVice->getTokenPayload('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ0aWQiOm51bGwsInN1YiI6IjEiLCJpYXQiOjE2NTQwNjUwMTR9.5TZugGVOi9TWFBmDUSJ6lqY560MW7r75nz5K2H5Hi_M');
    }

    /**
     * @return void
     * @throws AuthenticationException
     * @throws InvalidTokenException
     */
    public function testGetTokenPayloadAuthenticationException()
    {
        $this->expectException(AuthenticationException::class);
        $tokenSerVice = new TokenService();
        $payload = $tokenSerVice->getTokenPayload('Bearer eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.e30.-DQ7_Iy95Js80NMkvGVWMZl1gjfSJG1zFxZEslyEo90');
    }
}
