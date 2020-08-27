<?php

namespace app\services;

use Dotenv\Dotenv;
class DatabaseService implements IDatabaseService {

    /**
     * @return false|resource
     * Set the connection with the database
     * Uses .env variables for connection string
     */
    public function connect(){
        $dotenv=Dotenv::createUnsafeImmutable("\php_webshop");
        $dotenv->load();
        $conn = pg_connect("host=" . getenv("DB_HOST") . " dbname=" . getenv("DB_NAME") . " user=" . getenv("DB_USERNAME") . " password=". getenv("DB_PASSWORD"));
        return $conn;
    }
    public function login(DatabaseService $dbService){
    $asd = $dbService->connect();
    var_dump($asd);
    //$asdd = pg_query($asd,"aasd");
    //var_dump($asdd);
}}