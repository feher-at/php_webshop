<?php


namespace app\services;


class Validations
{

    /**
     * Returns error message if an input field was left empty.
     * @param $param
     * @return string
     */
    public static function requiredValidation($param)
    {
        if((empty($param))){
            return "This field is required";
        }

    }

    /**
     * Returns error message if an input was not an integer or null.
     * @param $param
     * @return string
     */
    public static function intValidation($param)
    {
        if($param != null && !intval($param))
        {
            return "This is not a number";
        }
    }

    /**
     * Validates an item's price .
     * @param $param
     * @return string|null
     * Returns the error message if there  else it returns null.
     */
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

    /**
     * Validates an email adress.
     * @param $email
     * @return string|null
     * Returns error message if the @email variable is empty else it returns null .
     */
    public static function emailValidation($email){

        $required =  Validations::requiredValidation($email);
        if(!empty($required))
            return $required;
        return null;
    }

    /**
     * Checks that the tax number was given and it's length is 11 .
     * @param $taxNumber
     * @return string|null
     * Returns error message if the validation was not successful, else it returns null.
     */
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

    /**
     * Checks that the tax number is 11 numbers long .
     * @param $taxNumber
     * @return string
     * Returns an error message if needed.
     */
    public static function updateTaxNumberValidation($taxNumber){
        if((strlen($taxNumber)>0 && strlen($taxNumber)<11) || strlen($taxNumber) > 11 ){
            return "This is not a valid tax number";
        }
    }

    /**
     * Validates a password-
     * @param $password
     * @return string|null
     * Returns an error message if the password wasn't given , else it returns null.
     */
    public static function passwordValidation($password){
        $required = Validations::requiredValidation($password);
        if(!empty($required)){
            return $required;
        }
        return null;
    }

    /**
     * Compares the two password fields .
     * @param $confirmPassword
     * @param $password
     * @return string|null
     * Returns error message if they are not equal, else it returns null.
     */
    public static function confirmPasswordValidation($confirmPassword,$password){
        if(empty($confirmPassword) || $confirmPassword != $password ){
            return "the passwords are not equal";
        }
        return null;
    }

    /**
     * Validates a shipping method .
     * @param $courier
     * @param $price
     * @return array|null
     */
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