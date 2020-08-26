<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;
use app\services\DatabaseService;

class AuthController extends Controller
{



    public function register()
    {
        /*$database = new DatabaseService();
        if($database->connect()){
            return "fasza vagy";
        }*/


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