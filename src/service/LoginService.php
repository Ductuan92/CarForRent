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
     * @return void
     * @throws \ReflectionException
     */
    public function Login($userRequest): User|null
    {
        $user = $this->userRepository->searchByUserName($userRequest->getUserName());
        if($user and password_verify($userRequest->getPassword(), $user->getPassword())){
            return $user;
        }
        else{
            return null;
        }
    }
}
