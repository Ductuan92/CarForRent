<?php

namespace MyApp\Controller;

use MyApp\App\View;

class HomeController
{
    /**
     * @return void
     */
    public function index(): void
    {
        View::render('index');
    }
}
