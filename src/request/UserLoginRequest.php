<?php

namespace MyApp\request;

use http\Exception;
use MyApp\App\Container;
use MyApp\App\View;
use MyApp\Exception\ValidationException;
use MyApp\Repository\UserRepository;
use MyApp\model\User;

class UserLoginRequest
{
    /**
     * @var string|mixed
     */
    private string $userName;

    /**
     * @var string|mixed
     */
    private string $password;

    /**
     * @var User \
     */
    private User $user;

    /**
     * @var Container
     */
    private Container $container;

    /**
     * @param $userName
     * @param $password
     */
    public function __construct()
    {
        $this->userName = $_POST['userName'];
        $this->password = $_POST['password'];
        $this->container = new Container();
        $this->validate();
    }

    /**
     * @return void
     * @throws \ReflectionException
     */
    private function validate(): void
    {
        $userRepository = $this->container->make(UserRepository::class);
        $data = $userRepository->searchByUserName($this->userName);
        $this->user = $this->container->make(User::class);
        try
        {
            $this->validateEmptyUserNamePassword();
            $this->validateUserName($data);
            $this->validatePassword($data);
            $this->setUser($data);

        }catch (ValidationException $error)
        {
            View::render(
                'login',[
                    'error' => $error->getMessage()
                ]
            );
        }
    }

    /**
     * @return void
     * @throws ValidationException
     */
    private function validateEmptyUserNamePassword(): void
    {
        if(empty($this->userName) || empty($this->password))
        {
            throw new ValidationException("Your user name or password invalid");
        }
    }

    /**
     * @param $data
     * @return void
     * @throws ValidationException
     */
    private function validateUserName($data): void
    {
        if(empty($data) || $data['user_name'] != $this->userName)
            throw new ValidationException("Username not exists please register!");
    }

    /**
     * @param $data
     * @return void
     * @throws ValidationException
     */
    private function validatePassword($data): void
    {
        $passwordHash = password_hash($this->password, PASSWORD_DEFAULT);
        if(!password_verify($this->password,$data['password']))
            throw new ValidationException("Your user name or password invalid");
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

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }
}
