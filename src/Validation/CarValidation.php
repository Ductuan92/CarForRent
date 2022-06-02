<?php

namespace MyApp\Validation;

class CarValidation
{
    public function validate($param):array
    {
        if(empty($param['brand']) || empty($param['price'])){
            return ['error' => 'brand and price can not be empty'];
        }
        return [];
    }
}
