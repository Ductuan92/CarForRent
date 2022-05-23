<?php

namespace MyApp\App;

class View
{
    /**
     * @param $view
     * @param array $data
     * @return void
     */
    public static function render($view, array $data=[]): void
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
}
