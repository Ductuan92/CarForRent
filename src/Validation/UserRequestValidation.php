<?php

namespace MyApp\Validation;

class UserRequestValidation
{
    /**
     * @param $userRequest
     * @return array|string[]
     */
    public function validateEmptyUserNamePassword($userRequest): array
    {
        if(empty($userRequest->getUserName()) || empty($userRequest->getPassword()))
            return [
                'login'=>'user name and password must not empty'
            ];
        else
            return [];
    }
}
