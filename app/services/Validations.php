<?php


namespace app\services;


class Validations
{


    public static function requiredValidation($param)
    {
        if((empty($param))){
            return "This field is required";
        }

    }

    public static function emailValidation($email){

        $required =  Validations::requiredValidation($email);
        if(!empty($required))
            return $required;
    }

    public static function registerTaxNumberValidation($taxNumber){
        $required = Validations::requiredValidation($taxNumber);
        if(!empty($required)){
            return $required;
        }
        else if((strlen($taxNumber)>0 && strlen($taxNumber)<11) || strlen($taxNumber) > 11 ){
            return "This is not a valid tax number";
        }
    }

    public static function passwordValidation($password){
        $required = Validations::requiredValidation($password);
        if(!empty($required)){
            return $required;
        }
    }

    public static function confirmPasswordValidation($confirmPassword,$password){
        if(empty($confirmPassword) || $confirmPassword != $password ){
            return "the passwords are not equal";
        }
    }
}