<?php

namespace app\services;



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
}