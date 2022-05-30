<?php

namespace MyApp\App;

use MyApp\Http\Response;

class View
{
    /**
     * @param $view
     * @param array $data
     * @return void
     */
    public static function render($view, array $data = []): void
    {
        require __DIR__ . "/../view/layout/header.php";
        require __DIR__ . "/../view/" . $view . ".php";
        require __DIR__ . "/../view/layout/footer.php";
    }

    /**
     * @param $url
     * @return void
     */
    public static function redirect($url): void
    {
        header("Location: $url");
    }

    public static function handle(Response $response)
    {
        http_response_code($response->getStatusCode());
        if (!empty($response->getTemplate())) {
            require Directory::getViewDir() . $response->getTemplate();
        }
        foreach ($response->getHeaders() as $key => $value){
            $header = $key. ': ' . $value;
            header($header);
        }
        if(!empty($response->getData())){
            echo $response->getData();
        }
    }
}
