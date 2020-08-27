<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;
use app\services\DatabaseService;
use app\services\IUserService;
use app\services\UserService;

class AuthController extends Controller
{

    public IUserService $userService;

    public function __construct(){

        $this->userService = new UserService();
    }


    public function register()
    {
        $this->setLayout('auth_layout');
        return $this->render('auth/register');
    }

    public function handleRegister(Request $request)
    {
        $body = $request->getBody();
        $userParams = ["user_email" =>$body['email'],"user_taxnum"=>intval($body['taxNumber']),
                        "user_password"=>$body['password'],"confirmed"=>true];
        $this->userService->registerUser($userParams);

        return $this->render('home/home');
    }

    public function login()
    {
        $this->setLayout('auth_layout');
        return $this->render('auth/login');
    }


}