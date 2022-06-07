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
    public function redirect($url): void
    {
        header("Location: $url");
    }

    /**
     * @param Response $response
     * @return bool
     */
    public function handle(Response $response): bool
    {
        http_response_code($response->getStatusCode());
        if (!empty($response->getTemplate())) {
            if (!empty($response->getReDirect())) {
                $this->redirect($response->getReDirect());
            }
            $this->render($response->getTemplate(), $response->getOption());
            return true;
        }
        return $this->handleApi($response);
    }

    /**
     * @param Response $response
     * @return bool
     */
    public function handleApi(Response $response): bool
    {
        foreach ($response->getHeaders() as $key => $value) {
            $header = $key . ': ' . $value;
            header($header);
        }
        if (!empty($response->getData())) {
            echo $response->getData();
            return true;
        }
        return false;
    }
}
