<?php

namespace app\services;
use app\services\Validations;



class UserService implements IUserService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    /**
     * @param array $params
     * @return array
     * Register the user with the given parameters,and return with the registered user's id
     */
    public function registerUser(array $params)
    {

        $query = "INSERT INTO users (user_email,user_taxnum,user_password,confirmed)
                    VALUES($1,$2,$3,$4)";
        $latestUserQuery = "SELECT * FROM users ORDER BY users.user_id DESC LIMIT 1 ";

        if($this->connection){
            pg_query_params($this->connection,$query,array($params['user_email'],$params['user_taxnum'],$params['user_password'],
                0));
            $result = pg_query($this->connection,$latestUserQuery);

            return pg_fetch_assoc($result);

        }
        else{
            $this->database->reConnect();
            pg_query_params($this->connection,$query,array($params['user_email'],$params['user_taxnum'],$params['user_password'],
                0));
            $result = pg_query($this->connection,$latestUserQuery);
            return pg_fetch_assoc($result);


        }

    }

    public function checkUserExists($email)
    {
        $result=pg_prepare($this->connection,"check_user","SELECT * FROM users WHERE user_email = $1 ");
        $result = pg_execute($this->connection,"check_user",$email);
        if(!$result){
            return null;
        }
        else{
            return pg_fetch_assoc($result);
        }

    }
    public function logInUser(array $credentials){
        $result = $this->checkUserExists(array($credentials['user_email']));
        if($result == null){
            return false;
        }
        else if($credentials['user_password'] != $result["user_password"]){
            return false;
        }
        else{
            return true;
        }

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

        $errors['email'] = Validations::emailValidation($validationParams['email']);

        $errors['taxNumber'] = Validations::taxNumberValidation($validationParams['taxNumber']);

        $errors['password'] = Validations::passwordValidation($validationParams['password']);

        $errors['confirmPassword'] = Validations::confirmPasswordValidation($validationParams['confirmPassword'],
                                                                            $validationParams['password']);
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = [];
    }


    public function getTheLatestRegisteredUser()
    {
        $this->database->reConnect();
        $result = pg_query($this->connection,"SELECT * FROM users ORDER BY users.user_id DESC LIMIT 1 ") or die ("Cannot execute query");
        pg_close($this->connection);
        return pg_fetch_object($result,'user_id');

    }
}