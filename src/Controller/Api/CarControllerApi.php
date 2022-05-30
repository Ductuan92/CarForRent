<?php

namespace MyApp\Controller\Api;

use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\model\Car;
use MyApp\Repository\CarRepository;

class CarControllerApi
{
    private Response $response;
    private Request $request;
    private CarRepository $carRepository;
    /**
     * @param Response $response
     * @param Request $request
     */public function __construct(
            Response $response,
            Request $request,
            CarRepository $carRepository)
    {
        $this->response = $response;
        $this->request = $request;
    }


    public function listAllCars(): Response
    {
        $car = new Car();
        $this->response->setHeaders(['']);
        return $this->response->success([$car]);
    }

    public function getCar(): Response
    {
        $car = new Car();
        $this->response->setHeaders(['']);
        return $this->response->success([$car]);
    }
}
