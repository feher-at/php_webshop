<?php


namespace app\services;


class ShippingService implements IShippingService
{

    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    public function createShipping($params)
    {

    }
}