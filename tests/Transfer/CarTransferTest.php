<?php

namespace Tests\Transfer;

use MyApp\model\Car;
use MyApp\Transfer\CarTransfer;
use PHPUnit\Framework\TestCase;

class CarTransferTest extends TestCase
{
    public function testFromArray()
    {
        $carTransfer = new CarTransfer();
        $param = [
            'brand'=>'Toyota',
            'price'=>'200 00 USD',
            'description'=> 'Relatively Affordable, Lots of Fun',
            'image'=>'1.png'];
        $result = $carTransfer->fromArray($param);
        $this->assertEquals('Toyota',$result->getBrand());
        $this->assertEquals('200 00 USD', $result->getPrice());
        $this->assertEquals('Relatively Affordable, Lots of Fun', $result->getDescription());
        $this->assertEquals('1.png', $result->getImage());
    }

    public function testToArray()
    {
        $car = new Car();
        $car->setId('1');
        $car->setBrand('Toyota');
        $car->setPrice('200 00 USD');
        $car->setDescription('Relatively Affordable, Lots of Fun');
        $car->setImage('1.png');

        $carTransfer = new CarTransfer();
        $result = $carTransfer->toArray($car , '');
        $expected = [
            'id'=>'1',
            'brand'=>'Toyota',
            'price'=>'200 00 USD',
            'description'=> 'Relatively Affordable, Lots of Fun',
            'image'=>'1.png'];
        $this->assertEquals($expected, $result);
    }

    public function testGetId()
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setId('12');
        $result = $carTransfer->getId();
        $this->assertEquals('12',$result);
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
