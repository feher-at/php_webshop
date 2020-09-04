<?php
namespace app\services;
use app\Core\Request;
use app\models\User;
use app\services\UserService;

class ProfileService implements IProfileService{
    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function getUser() : User{
        return $this->userService->getUserById($_COOKIE["type"]);

    }
    public function updateProfile($params){
        $this->userService->updateUser($params);
    }
    public function updateValidation(array $validationParams){
        $errors = [];
        if(array_key_exists('user_taxnum',$validationParams)) {
            $errors['taxNumber'] = Validations::updateTaxNumberValidation($validationParams['user_taxnum']);
        }
        if(!empty($validationParams['user_password'])){
        $errors['confirmPassword'] = Validations::confirmPasswordValidation($validationParams['confirmPassword'],
            $validationParams['user_password']);}
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = [];
    }
}