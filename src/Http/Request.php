<?php

namespace MyApp\Http;

class Request
{
    CONST METHOD_OPTION = 'OPTION';
    CONST METHOD_GET = 'GET';
    CONST METHOD_POST = 'POST';
    CONST METHOD_PUT = 'PUT';
    CONST METHOD_DELETE = 'DELETE';

    /**
     * @return mixed
     */
    public static function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    /**
     * @return mixed
     */
    public static function requestUri()
    {
        $path = strtok($_SERVER['REQUEST_URI'], '?');
        return $path;
    }
    public function getRequestBody()
    {
        return file_get_contents('php://input');
    }

    public function getRequestJsonBody()
    {
        $data = file_get_contents('php://input');

        return json_decode($data, true);
    }

    public function getTokenHeader()
    {
        return $_SERVER['HTTP_AUTHORIZATION'] ?? null;
    }

    public function getParams()
    {
        $path = $_SERVER['REQUEST_URI'];
        $pathComponents = parse_url($path);
        parse_str($pathComponents['query'], $params);
        return $params;
    }

    public function getFormParams(): array
    {
        return $_REQUEST;
    }

    public function getFile()
    {
        return $_FILES;
    }
}
