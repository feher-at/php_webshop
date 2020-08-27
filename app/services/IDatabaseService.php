<?php

namespace app\services;

interface IDatabaseService{

    function connect($host = "localhost", $dbname = "php_webshop", $user = "postgres", $password = "admin");
}