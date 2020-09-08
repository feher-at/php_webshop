<?php


namespace app\services;


class PaymentService implements IPaymentService
{

    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    public function getAllPaymentMethod()
    {
       $this->database->reConnect();

       return pg_fetch_all(pg_query('SELECT * FROM payment_methods'));
    }

    public function createPayment($paymentMethodsWithPrices,$itemID)
    {
        $query = 'INSERT INTO payment(item_id,payment_method_id,payment_handling_fee) VALUES($1,$2,$3)';
        $this->database->reConnect();
        foreach ($paymentMethodsWithPrices as $payment)
        {
            pg_query_params($this->connection,$query,array($payment['']));
        }
    }
}