<?php

namespace MyApp\Validation;

use MyApp\App\View;
use MyApp\Exception\ValidationException;
use MyApp\model\User;
use MyApp\Repository\UserRepository;

class UserLoginVerify
{

    /**
     * @param $dataPassword
     * @param $passwordRequest
     * @return array|string[]
     */
    public function verifyPassword($dataPassword, $passwordRequest): bool
    {
        //$passwordHash = password_hash($passwordRequest, PASSWORD_DEFAULT);
        if(password_verify($passwordRequest,$dataPassword))
            return true;
        else
            return false;
    }
}
