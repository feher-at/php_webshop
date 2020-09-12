<?php


namespace app\services;

use app\services\Interfaces\IPaymentService;


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

    public function createPayment($itemId,$paymentId,$handlingFee)
    {
        $this->database->reConnect();
        $query = 'INSERT INTO payment(item_id,payment_method_id,payment_handlingfee) VALUES($1,$2,$3)';
        $this->database->reConnect();
        pg_query_params($this->connection,$query,array($itemId,$paymentId,$handlingFee));

    }
    public function getAllPayment($itemId)
    {
        $this->database->reConnect();
        $query = "SELECT * FROM payment WHERE payment.item_id = $1";

        return pg_fetch_all(pg_query_params($this->connection,$query,array($itemId)));
    }

    public function getAllPaymentPriceAndName($itemId)
    {
        $this->database->reConnect();
        $query = "Select payment_methods.payment_method_name,payment.payment_handlingfee
                  From payment_methods Join payment On payment_methods.payment_method_id = payment.payment_method_id
                    Where payment.item_id = $1";

        return pg_fetch_all(pg_query_params($this->connection,$query,array($itemId)));
    }
    public function getGivenItemGivenPaymentPrice($itemId,$paymentMethodName)
    {
        $this->database->reConnect();
        $query = "Select payment.payment_handlingfee
                  From payment_methods Join payment On payment_methods.payment_method_id = payment.payment_method_id
	              Where payment_methods.payment_method_name = $1 and payment.item_id = $2";
        return pg_fetch_all(pg_query_params($this->connection,$query,array($paymentMethodName,$itemId)));
    }


}