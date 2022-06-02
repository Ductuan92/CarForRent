<?php

namespace MyApp\Controller;

use MyApp\App\View;
use MyApp\Http\Response;

class PageNotFoundController extends AbstractController
{
    /**
     * @return Response
     */
    public function pageNotFound(): Response
    {
        var_dump($this->response->view('PageNotFound'));
        return $this->response->view('PageNotFound');
    }
}
