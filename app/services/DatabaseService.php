<?php

namespace app\services;

class DatabaseService implements IDatabaseService {
     /*var $conn ;
    function __construct(){
    $this->conn = pg_connect("host=localhost dbname=php_webshop user=postgres password=admin") ;
    }*/
    /**
     * @param string $host
     * @param string $dbname
     * @param string $user
     * @param string $password
     * @return false|resource
     * Set the connection with the database
     */
    public function connect($host = "localhost", $dbname = "php_webshop", $user = "postgres", $password = "admin"){
        $conn = pg_connect("host=" . $host . " dbname=" . $dbname . " user=" . $user . " password=". $password);
        return $conn;
    }
    public function login(DatabaseService $dbService){
    $asd = $dbService->connect();
    var_dump($asd);
    //$asdd = pg_query($asd,"aasd");
    //var_dump($asdd);
}}