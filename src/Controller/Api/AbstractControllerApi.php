<?php

namespace MyApp\Controller\Api;

use MyApp\Http\Request;
use MyApp\Http\Response;

abstract class AbstractControllerApi
{
    protected Response $response;
    protected Request $request;

    /**
     * @param Response $response
     * @param Request $request
     */
    public function __construct(Response $response, Request $request)
    {
        $this->response = $response;
        $this->request = $request;
    }

}
