<?php

namespace MyApp\Validation;

use MyApp\request\UserLoginRequest;

class UserRequestValidation
{
    /**
     * @param $userRequest
     * @return array|string[]
     */
    public function validateEmptyUserNamePassword(UserLoginRequest $userRequest): array
    {
        if(empty($userRequest->getUserName()) || empty($userRequest->getPassword())){
            return [
                'error'=>'user name and password must not empty'
            ];
        }
        else{
            return [];
        }
    }
}
