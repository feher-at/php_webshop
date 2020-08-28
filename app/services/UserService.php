<?php

namespace app\services;
use app\core\Validation;



class UserService implements IUserService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }


    public function registerUser(array $params)
    {


        if($this->connection){

            pg_insert($this->connection,'users',$params);
            pg_close($this->connection);
        }
        else{
            $this->database->reConnect();
            pg_insert($this->connection,'users',$params);

        }

    }


    public function checkUserExits()
    {
        // TODO: Implement checkUserExits() method.
    }

    public function deleteUser()
    {
        // TODO: Implement deleteUser() method.
    }

    public function updateUser()
    {
        // TODO: Implement updateUser() method.
    }

    public function validation(array $validationParams)
    {
        $errors = [];
        foreach($validationParams as $key => $value)
        {
            if($key === 'email' && ! $value){
                $errors['email'] = "this field is required";
            }
            else if($key === 'taxNumber' && (strlen($value)>0 && strlen($value)<11)){
                $errors['taxNumber'] = "this is not a valid tax number";
            }
            else if($key === 'taxNumber' && !$value){
                $errors['taxNumber'] = "this field is required";
            }
            else if($key === 'password' && !$value ){
                $errors['password'] = "this field is required";
            }
            else if($key === 'confirmPassword' && !$value ){
                $errors['password'] = "this field is required";
            }
        }
        if($validationParams['password'] != $validationParams['confirmPassword'])
        {
            $errors['confirmPassword'] = "the passwords are not equal";
        }
        return $errors;
    }



}