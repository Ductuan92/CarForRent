<?php

namespace Tests\Repository;

use MyApp\Database\Database;
use MyApp\Repository\CarRepository;
use MyApp\Transfer\CarTransfer;
use PHPUnit\Framework\TestCase;

class CarRepositoryTest extends TestCase
{
    /**
     * @dataProvider createCarProvider
     * @param $param
     * @param $expected
     * @return void
     */
    public function testCreateCar($param, $expected)
    {
        $carTransfer = new CarTransfer();
        $carTransfer->setBrand($param['brand']);
        $carTransfer->setImage($param['image']);
        $carTransfer->setDescription($param['description']);
        $carTransfer->setPrice($param['price']);

        $carRepository = new CarRepository();
        $result = $carRepository->createCar($carTransfer);
        $carRepository = new CarRepository();
        $carRepository->deleteCar($carTransfer);

        $this->assertEquals($expected, $result);
    }

//    /**
//     * @dataProvider createCarProviderFalse
//     * @param $param
//     * @param $expected
//     * @return void
//     */
//    public function testCreateCarFalse($param, $expected)
//    {
//        $carTransfer = new CarTransfer();
//        $carTransfer->setBrand($param['brand']);
//        $carTransfer->setImage($param['image']);
//        $carTransfer->setDescription($param['description']);
//        $carTransfer->setPrice('--');
//
//        $carRepository = new CarRepository();
//        $result = $carRepository->createCar($carTransfer);
//        $this->assertNotNull($result['error']);
//    }

    public function createCarProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>[
                  'brand'=>'honda',
                  'price'=>'12 000',
                  'description'=>'only one',
                  'image'=>'1.jpeg'
              ],
              'expected'=>[]
          ]
        ];
    }

    public function createCarProviderFalse()
    {
        return [
            'unhappy-case-1'=>[
                'param'=>[
                    'brand'=>'honda',
                    'price'=>'12 000',
                    'description'=>'only one',
                    'image'=>''
                ],
                'expected'=>['error']
            ]
        ];
    }
}
