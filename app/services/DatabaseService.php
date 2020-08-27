<?php

namespace app\services;

class DatabaseService implements IDatabaseService {
    private static $instance = null;
    private $conn;

    private function __construct(){
        $this->conn = $this->connect();
    }

    /**
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @return false|resource
     * Set the connection with the database
     */
    public function connect($host = "localhost", $dbname = "php_webshop", $user = "postgres", $password = "admin"){
        $connect = pg_connect("host=" . $host . " dbname=" . $dbname . " user=" . $user . " password=". $password);
        return $connect;
    }

    public function reConnect(){
        $this->conn = $this->connect();
    }

    public static function getInstance(){
        if(!self::$instance)
        {
            self::$instance = new DatabaseService();
        }
        return  self::$instance;
    }

    public function getConnection(){
        return $this->conn;
    }
    public function login(DatabaseService $dbService){
    $asd = $dbService->connect();
    var_dump($asd);
    //$asdd = pg_query($asd,"aasd");
    //var_dump($asdd);
}}