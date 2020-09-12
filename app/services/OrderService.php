<?php


namespace app\services;


use app\models\Order;

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

    public function getAllOrdersOfUser($userId) {
        $result=pg_prepare($this->connection,"get_orders","SELECT * FROM orders WHERE item_id IN (SELECT item_id FROM items WHERE user_id = $1) ");
        $result = pg_execute($this->connection,"get_orders",array($userId));
        $fetchedResult =  pg_fetch_all($result);
        $orderArray = [];
        for($i=0;$i<count($fetchedResult);$i++){
            array_push($orderArray,new Order($fetchedResult[$i]));
        }
        return $orderArray;

    }

    public function orderValidation(array $validationParams)
    {
        $errors = array();

        $errors['first_name_error'] = Validations::requiredValidation($validationParams['first_name']);
        $errors['second_name_error'] = Validations::requiredValidation($validationParams['last_name']);
        $errors['address_error'] = Validations::requiredValidation($validationParams['customer_shipping_address']);
        $errors['billing_address_error'] = Validations::requiredValidation($validationParams['customer_billing_address']);
        $errors['email_error'] = Validations::emailValidation($validationParams['customer_email']);
        $errors['phone_number_error'] = Validations::phoneNumberValidation($validationParams['customer_phone']);
        $errors['quantity_number_error'] = Validations::quantityValidation($validationParams['item_quantity']);
        if($validationParams['payments'] == 'transaction')
        {
            $errors['recipient_error'] = Validations::requiredValidation($validationParams['bank_number_input']);
            $errors['bank_number_error'] = Validations::requiredValidation($validationParams['recipient_input']);
        }

        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = array();
    }
}