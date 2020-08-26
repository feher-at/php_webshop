<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;

class authController extends Controller
{

    public function register()
    {
        $this->setLayout('auth_layout');
        return $this->render('auth/register');
    }

    public function handleRegister(Request $request)
    {
        $body = $request->getBody();

        return $this->render('home/home');
    }

    public function login()
    {
        $this->setLayout('auth_layout');
        return $this->render('auth/login');
    }


}