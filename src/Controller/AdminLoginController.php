<?php

namespace MyApp\Controller;
use MyApp\App\View;
use MyApp\model\User;
use MyApp\Repository\UserRepository;

class AdminLoginController
{
    private UserRepository $userRepository;

    /**
     * @param User $user
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index(){
        // if user not login, redirect to login page otherwise render to admin page
        if (empty($_SESSION["userID"])){
            View::render('AdminLogin');
            View::redirect('/admin/login');
        }
        else{
            $user = $this->userRepository->searchById($_SESSION["userID"]);
            if($user->getRole() == 'admin')
            {
                View::render('admin');
            }
            else{
                View::render('PageNotFound');
            }

        }

    }
    public function carForm()
    {
    }

    public function setCar()
    {

    }
}
