<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;
use app\services\DatabaseService;
use app\services\IUserService;
use app\services\UserService;
use http\Message\Body;

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
        ini_set("SMTP", "aspmx.l.google.com");
        ini_set("sendmail_from", " YOURMAIL@gmail.com");

        $message = "The mail message was sent with the following mail setting:\r\nSMTP = aspmx.l.google.com\r\nsmtp_port = 25\r\nsendmail_from = YourMail@address.com";

        $headers = "From: YOURMAIL@gmail.com";




        $body = $request->getBody();
        $errors = $this->userService->validation($body);
        $bcryptedPassword = password_hash($body['password'],PASSWORD_BCRYPT);
        $userParams = ["user_email" =>$body['email'],"user_taxnum"=>intval($body['taxNumber']),
            "user_password"=>$bcryptedPassword,"confirmed"=>true];


        if(empty($errors)){
            $this->userService->registerUser($userParams);
            mail("makakoocelot@gmail.com", "Testing", $message, $headers);
            $this->redirect("/");
        }
        else{
            return $this->render('auth/register',$errors);
        }










    }

    public function login()
    {


        $this->setLayout('auth_layout');
        return $this->render('auth/login');

    }

    public function handleLogin(Request $request){

        $body = $request->getBody();
        $userParams = ["user_email" => $body['email'],"user_password"=>$body['password']];
        $result=$this->userService->logInUser($userParams);
        if($result){
            return $this->render('home/home');
        }
        else{
            return $this->render('auth/login');
        }
    }


}