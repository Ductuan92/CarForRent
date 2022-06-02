<?php

namespace Tests\Transfer;

use MyApp\model\Car;
use MyApp\Transfer\CarTransfer;
use PHPUnit\Framework\TestCase;

class CarTransferTest extends TestCase
{
    public function testFromArray()
    {
        $expected = new CarTransfer();
        $expected->setBrand('Toyota');
        $param = [
            'id'=>'12',
            'brand'=>'Toyota',
            'price'=>'200 00 USD',
            'description'=> 'Relatively Affordable, Lots of Fun',
            'image'=>'1.png'
        ];
        $carTransfer = new CarTransfer();
        $result = $carTransfer->fromArray($param);
    }

    public function testGetPrice()
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setPrice('200 000 USD');
        $result = $carTransfer->getPrice();
        $this->assertEquals('200 000 USD', $result);
    }

    public function testGetBrand()
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setBrand('Toyota');
        $result = $carTransfer->getBrand();
        $this->assertEquals('Toyota', $result);
    }

    public function testGetDescription()
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setDescription('Relatively Affordable, Lots of Fun');
        $result = $carTransfer->getDescription();
        $this->assertEquals('Relatively Affordable, Lots of Fun', $result);
    }

    public function testGetImage()
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setImage('1.png');
        $result = $carTransfer->getImage();
        $this->assertEquals('1.png', $result);
    }
}
