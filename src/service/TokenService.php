<?php

namespace MyApp\service;

use MyApp\model\Token;
use MyApp\Exception\AuthenticationException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use MyApp\Exception\InvalidTokenException;
use MyApp\model\User;

class TokenService
{
    protected string $secret = 'this token is secret';

    public function generate(User $user): string
    {
        $userId = $user->getId();
        $iat = time();
        $token = new Token();
        $payload = [
            'tid' => $token->getId(),
            'sub' => $userId,
            'iat' => $iat
        ];
        return JWT::encode($payload, $this->secret, 'HS256');
    }

    public function checkToken($token): array
    {
        $decoded = JWT::decode($token, new Key($this->secret, 'HS256'));

        return (array)$decoded;
    }

    public function getTokenPayload($authorizationToken): array
    {
        $bearerToken = explode('Bearer ', $authorizationToken);
        if (count($bearerToken) !== 2 || empty($bearerToken[1])) {
            throw new InvalidTokenException();
        }
        $token = $bearerToken[1];
        $payload = $this->checkToken($token);
        if ($payload) {
            return $payload;
        }

        throw new AuthenticationException();
    }
}
