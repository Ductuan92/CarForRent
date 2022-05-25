<?php

namespace MyApp\Controller;

use MyApp\App\View;

class HomeController
{
    /**
     * @return void
     */
    public function index(): bool
    {
        View::render('index');
        return true;
    }
}
