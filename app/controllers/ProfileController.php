<?php
namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IProfileService;
use app\services\ProfileService;
use app\services\UserService;
use app\services\IUserService;
class ProfileController extends Controller{
    public function __construct(){
        $this->profileService = new ProfileService();
        $this->userService = new userService();
    }
    public function getProfilePage(){
        $this->setLayout('layout');
        return $this->render('profile/profile',$this->profileService->getUser());
    }
    public function getProfileUpdatePage(){
        $this->setLayout('layout');
        return $this->render('profile/profileUpdate',$this->profileService->getUser());
    }
    public function getCurrentUser(){
        return $this->profileService->getUser();
    }

    public function update(Request $request)
    {
        $body = $request->getBody();
        $errors = $this->userService->validation($body);
        if(!empty($errors)){
            return $this->render('profile/profileUpdate',$errors);
        }

        return $this->render('profile/profile');
    }


}