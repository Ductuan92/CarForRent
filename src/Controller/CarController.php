<?php

namespace MyApp\Controller;

use MyApp\Http\Request;
use MyApp\Http\Response;
use MyApp\model\Car;
use MyApp\Repository\CarRepository;
use MyApp\service\FileService;
use MyApp\Transfer\CarTransfer;
use MyApp\Validation\CarValidation;

class CarController extends AbstractController
{

    private FileService $fileService;
    private CarRepository $carRepository;
    private CarTransfer $carTransfer;
    private CarValidation $carValidation;

    public function __construct(
        Request $request,
        Response $response,
        CarRepository $carRepository,
        CarTransfer $carTransfer,
        FileService $fileService,
        CarValidation $carValidation,
    )
    {
        $this->carRepository = $carRepository;
        $this->carTransfer = $carTransfer;
        $this->fileService = $fileService;
        $this->carValidation = $carValidation;
        parent::__construct($request, $response);
    }

    /**
     * @return Response
     */
    public function addCar(): Response
    {
        $param = $this->request->getFormParams();
        $carImg = $this->request->getFile()['image'];

        $message = $this->carValidation->validate($param);
        if(empty($message)){
            $message = $this->upLoad($param, $carImg);
        }
        if(empty($message)){
            $message = ['success' => 'Car is added successfully!'];
        }
        return $this->response->view('adminAddCar', $message);
    }

    /**
     * @param $param
     * @param $carImg
     * @return array
     */
    private function upLoad($param, $carImg): array
    {
        $result = $this->fileService->UploadToS3($carImg);
        if(isset($result['error'])){
            return $result;

        }else{
            $param = array_merge($param,["image"=>$result]);
            $carTransfer = $this->carTransfer->fromArray($param);
            return $this->carRepository->createCar($carTransfer);
        }
    }

    /**
     * @return Response
     */
    public function addCarPage() :Response
    {
        $session = $_SESSION['userName'] ?? null;
        $message = [];
        if($session == null){
            $message = array_merge(['error'=>'Please login first']);
        }
        return $this->response->view('adminAddCar', $message);
    }

    /**
     * @return Response
     */
    public function index(){
        $cars = $this->carRepository->getAllCar();
        return $this->response->view('index', $cars);
    }
}
