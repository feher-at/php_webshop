<?php

namespace app\services;

interface IDatabaseService{
    public function connect($host = "localhost", $dbname = "php_webshop", $user = "postgres", $password = "admin");
}