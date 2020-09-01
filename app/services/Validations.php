<?php


namespace app\services;


class Validations
{
    public static function emailValidation($email){
        if(empty($email)){
            return "This field is required";
        }
    }

    public static function taxNumberValidation($taxNumber){
        if(empty($taxNumber)){
            return "This field is required";
        }
        else if((strlen($taxNumber)>0 && strlen($taxNumber)<11) || strlen($taxNumber) > 11 ){
            return "This is not a valid tax number";
        }
    }

    public static function passwordValidation($password){
        if(empty($password)){
            return "This field is required";
        }
    }

    public static function confirmPasswordValidation($confirmPassword,$password){
        if(empty($confirmPassword) || $confirmPassword != $password ){
            return "the passwords are not equal";
        }
    }
}