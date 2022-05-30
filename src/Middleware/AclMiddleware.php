<?php

namespace MyApp\Middleware;

use MyApp\App\Route;
use MyApp\Http\Request;
use MyApp\Repository\UserRepository;
use MyApp\service\TokenService;
use MyApp\Exception\UnauthorizedException;

class AclMiddleware
{
    private Request $request;
    private TokenService $tokenService;
    private UserRepository $userRepository;

    /**
     * @param Request $request
     * @param TokenService $tokenService
     * @param UserRepository $userRepository
     */
    public function __construct(Request $request, TokenService $tokenService, UserRepository $userRepository)
    {
        $this->request = $request;
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
    }

    public function verify(Route $route): bool
    {
        $role = $route->getRole();
        if(empty($role)){
            return true;
        }
        $authorizationToken = $this->request->getTokenHeader();
        $tokenPayload = $this->tokenService->getTokenPayload($authorizationToken);
        $userId = $tokenPayload['sub'];
        $user = $this->userRepository->searchById($userId);
        if ($user->getRole() === $role) {
            return true;
        }
        throw new UnauthorizedException();
    }
}
