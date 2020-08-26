<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;

class authController extends Controller
{

    public function register()
    {
        return $this->render('register');
    }

    public function handleRegister(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
        return 'submitted data';
    }

    public function login()
    {
        return $this->render('login');
    }


}