<?php


namespace app\services;


use app\models\Order;
use app\services\Interfaces\IOrderService;

class OrderService extends AbstractServices implements IOrderService
{




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
        $result=pg_prepare($this->connection,"get_all_orders","SELECT * FROM orders WHERE item_id IN (SELECT item_id FROM items WHERE user_id = $1) ");
        $result = pg_execute($this->connection,"get_all_orders",array($userId));
        $fetchedResult =  pg_fetch_all($result);
        $orderArray = [];
        if(empty($fetchedResult)){
            return $orderArray;
        }
        for($i=0;$i<count($fetchedResult);$i++){
            array_push($orderArray,new Order($fetchedResult[$i]));
        }
        return $orderArray;

    }

    /**
     * Validate the order
     * @param array $validationParams
     * @return array
     */
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

    /**
     * Returns an order by its id.
     * @param $orderId
     * @return Order
     */
    public function getOrderById($orderId){
        $result=pg_prepare($this->connection,"get_order","SELECT * FROM orders WHERE order_id = $1 ");
        $result = pg_execute($this->connection,"get_order",array($orderId));
        $fetchedResult = pg_fetch_assoc($result);
        return new Order($fetchedResult);

    }

    /**
     * Checks if the order was sent for the currently logged in user's item.
     * @param $userId
     * @param $orderId
     * @return bool
     */
    public function checkOrderOwner($userId,$orderId){
        $result=pg_prepare($this->connection,"check_owner","SELECT items.user_id FROM orders JOIN items ON orders.item_id = items.item_id WHERE orders.order_id = $1 ");
        $result = pg_execute($this->connection,"check_owner",array($orderId));
        $dbUserId = pg_fetch_result($result,0,0);
        if($dbUserId === $userId){
            return true;
        }
        return false;
    }

    /**
     * Sets an order's status to under process in the database.
     * @param $orderId
     */
    public function setStatusToUnderProcess($orderId){
        $result=pg_prepare($this->connection,"to_under_process","UPDATE orders SET order_status = 'under process' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_under_process",array($orderId));
    }
    /**
     * Sets an order's status to delivery in the database.
     * @param $orderId
     */
    public function setStatusToDelivery($orderId){
        $result=pg_prepare($this->connection,"to_delivery","UPDATE orders SET order_status = 'delivery' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_delivery",array($orderId));
    }
    /**
     * Sets an order's status to delivered in the database.
     * @param $orderId
     */
    public function setStatusToDelivered($orderId){
        $result=pg_prepare($this->connection,"to_delivered","UPDATE orders SET order_status = 'delivered' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_delivered",array($orderId));
    }
    /**
     * Sets an order's status to deleted in the database.
     * @param $orderId
     */
    public function setStatusToDeleted($orderId){
        $result=pg_prepare($this->connection,"to_deleted","UPDATE orders SET order_status = 'deleted' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_deleted",array($orderId));
    }
}