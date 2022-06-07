<?php

namespace Tests\Controller;

use MyApp\Controller\CarController;
use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\Repository\CarRepository;
use MyApp\service\FileService;
use MyApp\Transfer\CarTransfer;
use MyApp\Validation\CarValidation;
use PHPUnit\Framework\TestCase;

class CarControllerTest extends TestCase
{
    public function addCarDataProvider()
    {
        return [
          'happy-case-1'=>[
              'param'=>[],
              'expected'
          ]
        ];
    }

    /**
     * @dataProvider addCarPageDataProvider
     * @return void
     */
    public function testAddCarPage($param, $expected)
    {
        $_SESSION["userName"] = $param['session'];

        $response = new Response();
        $carRepository = new CarRepository();
        $response->view($expected['view'], $expected['message']);

        $carController = $this->callCarController($carRepository);
        $result = $carController->addCarPage();
        $this->assertEquals($response, $result);
    }

    public function addCarPageDataProvider()
    {
        return [
            'happy-case-1'=>[
                'param'=>[
                    'session' => 'anh'
                ],
                'expected' => [
                    'message'=>[],
                    'view'=>'adminAddCar'
                ]
            ],
            'happy-case-2'=>[
                'param'=>[
                    'session' => ''
                ],
                'expected' => [
                    'message'=>['error'=>'Please login first'],
                    'view'=>'adminAddCar'
                ]
            ]
        ];
    }

    public function testIndex()
    {
        $carRepository = $this->getMockBuilder(CarRepository::class)->disableOriginalConstructor()->getMock();
        $carRepository->expects($this->any())->method('getAllCar')->willReturn([
            'id'=>'1',
            'brand'=>'honda',
            'description'=>'only one'
        ]);
        $car = $carRepository->getAllCar();
        $response = new Response();
        $response->view('index', $car);

        $carController = $this->callCarController($carRepository);
        $result = $carController->index();
        $this->assertEquals($response, $result);
    }

    private function callCarController($carRepository)
    {
        $response = new Response();

        $request = new Request();
        $carTransfer = new CarTransfer();
        $fileService = new FileService();
        $carValidation = new CarValidation();

        return new CarController($request, $response, $carRepository, $carTransfer, $fileService, $carValidation);

    }
}
