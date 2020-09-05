<?php
namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IProfileService;
use app\services\ProfileService;
use app\services\UserService;
use app\services\IUserService;
use app\services\EmailService;
use PHPMailer\PHPMailer\Exception;

class ProfileController extends Controller{

    private ProfileService $profileService;
    private UserService $userService;
    private EmailService $emailService;

    public function __construct(){
        $this->profileService = new ProfileService();
        $this->userService = new userService();
        $this->emailService = new EmailService();
    }
    public function getProfilePage(){
        if( isset($_COOKIE["type"])){
            $this->setLayout('layout');
            return $this->render('profile/profile',$this->profileService->getUser());
        }
        $this->redirect('/login');
    }
    public function getProfileUpdatePage(){
        $this->setLayout('layout');
        return $this->render('profile/profileUpdate',$this->profileService->getUser());
    }
    public function getCurrentUser(){
        return $this->profileService->getUser();
    }
    public function sendUpdateEmail(){
        $address = "phptestuser01@gmail.com";
        $subject ="Successful update";
        $message = "You have successfully updated your profile informations!";
        try {
            $this->emailService->EmailSending($subject,$message,$address);
        } catch (Exception $e) {
            echo $e->errorMessage();
        }
    }
    public function removeEmptyValues($userData){
        foreach($userData as $key => $value){
            if($value == "" || $key == 'confirmPassword'){
                unset($userData[$key]);}
        }
        return $userData;
    }

    public function update(Request $request)
    {
        $body = $request->getBody();
        $errors = $this->profileService->updateValidation($body);
        if($errors != []){
            return $this->render('profile/profileUpdate',$errors);
        }
        $this->sendUpdateEmail();
        $body = $this->removeEmptyValues($body);
        if(array_key_exists('user_password',$body)){
            password_hash($body['user_password'],PASSWORD_BCRYPT);
        }
        $this->profileService->updateProfile($body);
        return $this->render('profile/profile',$this->profileService->getUser());
    }


}