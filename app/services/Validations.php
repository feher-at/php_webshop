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

    public static function intValidation($param)
    {
        if($param != null && !intval($param))
        {
            return "This is not a number";
        }
    }

    public static function itemPriceValidation($param)
    {
        $required = Validations::requiredValidation($param);
        $isNumber = Validations::intValidation($param);

        if(!empty($required))
        {
            return $required;
        }
        elseif (!empty($isNumber))
        {
            return $isNumber;
        }
        return null;
    }

    public static function emailValidation($email){

        $required =  Validations::requiredValidation($email);
        if(!empty($required))
            return $required;
        return null;
    }

    public static function registerTaxNumberValidation($taxNumber){
        $required = Validations::requiredValidation($taxNumber);
        if(!empty($required)){
            return $required;
        }
        else if((strlen($taxNumber)>0 && strlen($taxNumber)<11) || strlen($taxNumber) > 11 ){
            return "This is not a valid tax number";
        }
        return null;
    }


    public static function passwordValidation($password){
        $required = Validations::requiredValidation($password);
        if(!empty($required)){
            return $required;
        }
        return null;
    }

    public static function confirmPasswordValidation($confirmPassword,$password){
        if(empty($confirmPassword) || $confirmPassword != $password ){
            return "the passwords are not equal";
        }
        return null;
    }

    public static function shippingValidation($courier,$price)
    {
        $courierRequired = Validations::requiredValidation($courier);
        $courierPrice = Validations::itemPriceValidation($price);
        if(!empty($courierRequired) || !empty($courierPrice))
        {
            return $errors = array('courier_required_error' => $courierRequired,
                                   'courier_price_error'=> $courierPrice );
        }

        return null;
    }
}