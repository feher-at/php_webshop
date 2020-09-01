<?php


namespace app\controllers;

use app\core\Controller;
use app\Core\Request;
use app\services\DatabaseService;
use app\services\IUserService;
use app\services\UserService;
use app\services\EmailService;
use http\Cookie;
use http\Message\Body;
use PHPMailer\PHPMailer\Exception;




class AuthController extends Controller
{

    private IUserService $userService;
    private EmailService $emailService;

    public function __construct(){

        $this->userService = new UserService();
        $this->emailService = new EmailService();
    }


    public function register()
    {
        $this->setLayout('auth_layout');
        return $this->render('auth/register');
    }

    public function handleRegister(Request $request)
    {

        $body = $request->getBody();
        $errors = $this->userService->validation($body);


        $address = "phptestuser01@gmail.com";
        $bcryptedPassword = password_hash($body['password'],PASSWORD_BCRYPT);
        $userParams = ["user_email" =>$body['email'],"user_taxnum"=>intval($body['taxNumber']),
            "user_password"=>$bcryptedPassword,"confirmed"=>false];


        if(empty($errors)){

            $latestRegisteredUserHashedEmail = $this->userService->registerUser($userParams);

            $validationLink = 'http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT'].'/register/validation?email='.$latestRegisteredUserHashedEmail['hashed_email_for_validation'];
            $subject = "Welcome on the phpWebshop";
            $message = "This is your first email,enjoy!\n
                        To validate your registration click on this link :". $validationLink;
            try {
                $this->emailService->EmailSending($subject,$message,$address);
                $this->redirect("/");
            } catch (Exception $e) {
                echo $e->errorMessage();

            }

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
        if($result==false){
            return $this->render('auth/login');

        }
        else{
            //$this->userService->updateSessionTable($result);
            setcookie("type",$result,time()+604,800);
            $this->redirect("/");
        }
        return false;
    }
    public function logout(Request $request){
        setcookie("type","",time()-604,800);
        $this->redirect("/");

    }

    public function validation(Request $request)
    {
        $this->setLayout('auth_layout');
        $body = $request ->getBody();

        $user = ($this->userService->getUserByHashedEmail($body['email']));
        $this->userService->updateUserConfirmColumn($user->user_id);

        return $this->render('validation/userValidation');
    }


}