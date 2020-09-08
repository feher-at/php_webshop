<?php

namespace app\services;

use Dotenv\Dotenv;
class DatabaseService implements IDatabaseService {
    private static $instance = null;
    private $conn;

    private function __construct(){
        $this->conn = $this->connect();
    }


    public function reConnect(){
        if(!$this->conn)
            $this->conn = $this->connect();
    }

    public static function getInstance(){
        if(!self::$instance)
        {
            self::$instance = new DatabaseService();
        }
        return  self::$instance;
    }

    public function getConnection()
    {
        return $this->conn;
    }

    /**
     * Set the connection with the database
     * Uses .env variables for connection string
     * @return false|resource
     */
    public function connect(){
        $dotenv=Dotenv::createUnsafeImmutable(dirname(__FILE__,3,));
        $dotenv->load();
        $conn = pg_connect("host=" . getenv("DB_HOST") . " dbname=" . getenv("DB_NAME") . " user=" . getenv("DB_USERNAME") . " password=". getenv("DB_PASSWORD"));
        return $conn;
    }
    }