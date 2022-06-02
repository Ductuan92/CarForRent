<?php

namespace MyApp\service;

use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\App\View;
use phpDocumentor\Reflection\Types\Nullable;

class LoginService
{
    private UserRepository $userRepository;

    public function __construct(UserRepository  $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param $userRequest
     * @return User|null
     */
    public function Login($userRequest): User|null
    {
        $user = $this->userRepository->searchByUserName($userRequest->getUserName());
        if($user && $this->verifyPassword($userRequest->getPassword(), $user->getPassword())){
            echo $user->getUserName();
            return $user;
        }
        return null;
    }

    private function verifyPassword($plainPassword, $password): bool
    {
        if(password_verify($plainPassword, $password)){
            return True;
        }
        return false;
    }
}
