<?php

namespace MyApp\request;

use http\Exception;
use MyApp\App\View;
use MyApp\Repository\UserRepository;
use MyApp\model\User;

class UserLoginRequest
{

    private string $userName;
    private string $password;

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->userName;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param $userName
     * @return void
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @param mixed $password
     * @return void
     */
    public function setPassword(mixed $password): void
    {
        $this->password = $password;
    }
}
