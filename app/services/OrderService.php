<?php


namespace app\services;


class OrderService implements IOrderService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    public function getAllOrder()
    {
        // TODO: Implement getAllOrder() method.
    }

    public function updateOrder()
    {
        // TODO: Implement updateOrder() method.
    }

    public function deleteOrder()
    {
        // TODO: Implement deleteOrder() method.
    }

    public function createOrder(array $orderParams)
    {
        $this->database->reConnect();
        $query = "INSERT INTO orders(customer_name,
                                     customer_shipping_address,
                                     customer_billing_address,
                                     customer_phone,
                                     customer_email,
                                     item_id,
                                     item_current_price,
                                     item_quantity,
                                     order_status)
                                     VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9)";
        pg_query_params($this->connection,$query,$orderParams);

    }

}