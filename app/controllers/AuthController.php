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
        $this->setLayout('layout');
        return $this->render('auth/register');
    }

    /**
     * Register the user, and send an email it's email address to validate the user's registration.
     * The registration email will include a link with the validation page and a hashed data,what is the
     * registered user's email,if the user clicking on the link,he will get validating.
     * @param Request $request
     * The request which the user send to the server with all the data
     * @return string|string[]
     * Return to the register page with the errors if there any.
     */
    public function handleRegister(Request $request)
    {

        $body = $request->getBody();
        $errors = $this->userService->registrationValidation($body);


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
                $this->redirect('/');
            } catch (Exception $e) {
                echo $e->errorMessage();

            }

        }
        else{
            return $this->render('auth/register',$errors);
        }
    }
    /**
     * Returns the login view with the layout.
    */
    public function login()
    {
        $this->setLayout('layout');
        return $this->render('auth/login');
    }

    /**
     * Compares the given credentials with the users table in the database.
     * @param Request $request
     * Request contains the credentials given by the user on the login screen.
     * @return false|string|string[]
     * If the credentials doesn't match the data stored in the database it re-renders the login view.
     * If the matching function comes back with a true it gives out a cookie to the logged in user with a one week timeout
     * and redirects to the homepage.
     */
    public function handleLogin(Request $request){

        $body = $request->getBody();
        $userParams = ["user_email" => $body['email'],"user_password"=>$body['password']];
        $result=$this->userService->logInUser($userParams);
        if($result==false){
            return $this->render('auth/login');

        }
        else{
            setcookie("type",$result,time()+604800);
            $this->redirect("/");
        }
        return false;
    }
    /**
     * Logs the user out by deleting their cookie and redirects to the homepage.
    */
    public function logout(Request $request){
        setcookie("type","",time()-604800);
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
    /**
     * Checks if the user's browser has the required cookie .
     * If it has the cookie, the user is logged in and the method returns true
     * else it redirects to the login view.
    */
    public function authentication(){
        if(isset($_COOKIE["type"])){
            return true;
        }
        else{
            $this->redirect("auth/login");
        }
    }


}