<?php

namespace MyApp\Controller\Api;

use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\model\Car;
use MyApp\Repository\CarRepository;
use MyApp\service\FileService;
use MyApp\Transfer\CarTransfer;
use MyApp\Validation\CarValidation;

class CarControllerApi extends AbstractControllerApi
{
    CONST TARGET_DIR = "assets/img/";

    private CarRepository $carRepository;
    private CarTransfer $carTransfer;
    private CarValidation $carValidation;
    private FileService $fileService;

     public function __construct(
        Response $response,
        Request $request,
        CarRepository $carRepository,
        CarTransfer $carTransfer,
        CarValidation $carValidation,
        FileService $fileService,
     )
    {
        parent::__construct($response, $request);
        $this->carRepository = $carRepository;
        $this->carTransfer = $carTransfer;
        $this->carValidation = $carValidation;
        $this->fileService = $fileService;
    }


    public function index(): Response
    {
        $cars = $this->carRepository->getAllCar();
        $carTransfer = [];
        foreach ($cars as $car){
            $arrayCar = $this->carTransfer->toArray($car, self::TARGET_DIR);
            array_push($carTransfer, ['car'=>$arrayCar]);
        }
        return $this->response->success($carTransfer);
    }

    public function getCar(): Response
    {
        $car = new Car();
        $this->response->setHeaders(['']);
        return $this->response->success([$car]);
    }

    public function addCar(): Response
    {
        $param = $this->request->getParams();
        $carImg = $this->request->getFile()['image'];

        $message = $this->carValidation->validate($param);
        if(empty($message)){
            $message = $this->upLoad($param, $carImg);
        }

        if(empty($message)){
            return $this->response->success();
        }
        return $this->response->error($message);
    }

    private function upLoad($param, $carImg): array
    {
        $result = $this->fileService->handleUpload($carImg);
        if(isset($result['error'])){
            return $result;

        }else{
            $param = array_merge($param,["image"=>$result]);
            $carTransfer = $this->carTransfer->fromArray($param);
            return $this->carRepository->createCar($carTransfer);
        }
    }
}
