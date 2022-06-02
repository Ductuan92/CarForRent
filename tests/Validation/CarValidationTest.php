<?php

namespace Tests\Validation;

use MyApp\Http\Request;
use MyApp\Validation\CarValidation;
use PHPUnit\Framework\TestCase;

class CarValidationTest extends TestCase
{
    /**
     * @dataProvider validateProvider
     * @return void
     */
    public function testValidate($param, $expected)
    {
        $carValidation = new CarValidation();
        $result = $carValidation->validate($param);
        $this->assertEquals($expected, $result);
    }

    public function validateProvider()
    {
        return [
            'happy-case-1'=>[
                'param' =>[
                    'brand'=>'Toyota',
                    'price'=>'12 000 USD'
                ],
                'expected'=>[]
            ],
            'unhappy-case-1'=>[
                'param' =>[
                    'brand'=>'',
                    'price'=>'12 000 USD'
                ],
                'expected'=>['error' => 'brand and price can not be empty']
            ]
        ];
    }
}
