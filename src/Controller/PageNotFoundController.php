<?php

namespace MyApp\Controller;

use MyApp\App\View;

class PageNotFoundController
{
    /**
     * @return bool
     */
    public function PageNotFound()
    {
        View::render('PageNotFound');
    }
}
