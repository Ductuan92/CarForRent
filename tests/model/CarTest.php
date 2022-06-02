<?php

namespace Tests\model;

use MyApp\model\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function testGetImage()
    {
        $car = new Car();
        $car->setImage('1.png');
        $result = $car->getImage();
        $this->assertEquals('1.png', $result);
    }

    public function testGetId()
    {
        $car = new Car();
        $car->setId('123');
        $result = $car->getId();
        $this->assertEquals('123', $result);
    }

    public function testGetBrand()
    {
        $car = new Car();
        $car->setBrand('Toyota');
        $result = $car->getBrand();
        $this->assertEquals('Toyota', $result);
    }

    public function testDescription()
    {
        $car = new Car();
        $car->setDescription('Relatively Affordable, Lots of Fun');
        $result = $car->getDescription();
        $this->assertEquals('Relatively Affordable, Lots of Fun', $result);
    }

    public function testPrice()
    {
        $car = new Car();
        $car->setPrice('200 000 USD');
        $result = $car->getPrice();
        $this->assertEquals('200 000 USD', $result);
    }
}
