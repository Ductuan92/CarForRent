<?php

namespace MyApp\Middleware;

use MyApp\App\Route;
use MyApp\Http\Request;
use MyApp\Repository\UserRepository;
use MyApp\service\TokenService;

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
    public function __construct(
        Request $request,
        TokenService $tokenService,
        UserRepository $userRepository,
    )
    {
        $this->request = $request;
        $this->tokenService = $tokenService;
        $this->userRepository = $userRepository;
    }

    /**
     * @param Route $route
     * @return array|string[]
     */
    public function verify(Route $route): array
    {
        $role = $route->getRole();
        if(empty($role)){
            return [];
        }
        $uri = substr(Request::requestUri(), 1, 3);
        if($uri == 'api'){
            return $this->checkToken($role);
        }
        return $this->checkSession($role);
    }

    /**
     * @param $role
     * @return array|string[]
     */
    private function checkToken($role): array
    {
        $authorizationToken = $this->request->getTokenHeader();
        $tokenPayload = $this->tokenService->getTokenPayload($authorizationToken);
        $userId = $tokenPayload['sub'];
        $user = $this->userRepository->searchById($userId);
        if ($user->getRole() === $role) {
            return [];
        }
        return ['User are not permitted'];
    }

    /**
     * @param $role
     * @return array|string[]
     */
    private function checkSession($role): array
    {
        $session = $_SESSION['userName'] ?? null;
        if($session != null){
            $user = $this->userRepository->searchByUserName($_SESSION['userName']);
            if($user->getRole() == $role){
                return [];
            }
        }
        return ['User are not permitted'];
    }
}
