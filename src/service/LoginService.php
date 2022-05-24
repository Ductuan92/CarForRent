<?php

namespace MyApp\service;

use MyApp\Validation\UserLoginVerify;
use MyApp\Exception\ValidationException;
use MyApp\model\User;
use MyApp\Repository\UserRepository;
use MyApp\App\View;

class LoginService
{
    private User $user;
    private UserRepository $userRepository;
    private UserLoginVerify $userLoginVerify;

    public function __construct(
        UserRepository  $userRepository,
        User            $user,
        UserLoginVerify $userLoginVerify,
        UserLoginVerify $userLoginValidation
    )
    {
        $this->userRepository = $userRepository;
        $this->user = $user;
        $this->userLoginVerify = $userLoginVerify;
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function Login($userRequest): User|bool
    {
        $data = $this->userRepository->searchByUserName($userRequest->getUserName());
        if($data)
        {
            $check = $this->userLoginVerify->verifyPassword($data['password'], $userRequest->getPassword());
            if($check) {
                $this->setUser($data);
                return $this->user;
            }
        }
        View::render('login',[
            'login'=>'user or password is incorrect'
        ]);
        return false;
}

    /**
     * @param $data
     * @return void
     */
    private  function setUser($data): void
    {
        $this->user->setId($data['id']);
        $this->user->setEmail($data['email']);
        $this->user->setUserName($data['user_name']);
    }
}
