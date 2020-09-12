<?php


namespace app\services;


Abstract class AbstractServices
{
    protected $database;
    protected $connection;

   public function __construct()
   {
       $this->database = DatabaseService::getInstance();
       $this->connection = $this->database->getConnection();
   }
}