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
}