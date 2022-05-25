<?php

namespace MyApp\request;

use http\Exception;
use MyApp\App\View;
use MyApp\Repository\UserRepository;
use MyApp\model\User;

class UserLoginRequest
{

    private $userName;
    private $password;

    public function __construct()
    {
        $this->userName = $_POST['userName']??"";
        $this->password = $_POST['password']??"";
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed|string $userName
     */
    public function setUserName(mixed $userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed|string $password
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }
}
