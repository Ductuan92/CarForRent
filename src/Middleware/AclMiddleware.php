<?php

namespace MyApp\Middleware;

use MyApp\App\Route;
use MyApp\App\View;
use MyApp\Http\Request;
use MyApp\Repository\UserRepository;
use MyApp\service\LoginService;
use MyApp\service\TokenService;
use MyApp\Exception\UnauthorizedException;
use mysql_xdevapi\Exception;

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

    public function verify(Route $route): bool
    {
        $role = $route->getRole();
        if(empty($role)){
            return true;
        }
        $uri = substr(Request::requestUri(), 1, 3);
        if($uri == 'api'){
            $this->checkToken($role);
            return true;
        }
        try{
            $this->checkSession($role);
        } catch(\Exception $exception){
            echo $exception->getMessage();
            return false;
        }
        return true;
    }

    private function checkToken($role): bool
    {
        $authorizationToken = $this->request->getTokenHeader();
        $tokenPayload = $this->tokenService->getTokenPayload($authorizationToken);
        $userId = $tokenPayload['sub'];
        $user = $this->userRepository->searchById($userId);
        if ($user->getRole() === $role) {
            return true;
        }
        throw new UnauthorizedException('User are not permitted');
    }
    private function checkSession($role): bool
    {
        $session = $_SESSION['userName'] ?? null;
        if($session != null){
            $user = $this->userRepository->searchByUserName($_SESSION['userName']);
            if($user->getRole() == $role){
                return true;
            }
        }
        throw new UnauthorizedException('User are not permitted');
    }
}
