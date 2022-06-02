<?php

namespace MyApp\Controller;

use MyApp\App\View;
use MyApp\Http\Request;
use MyApp\Http\Response;

class HomeController extends AbstractController
{

    /**
     * @return Response
     */
    public function index(): Response
    {
        return $this->response->view('index');
    }
}
