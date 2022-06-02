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
        return $this->response->view('PageNotFound');
    }
}
