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
        // TODO: Implement createOrder() method.
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
    public function getOrderById($orderId){
        $result=pg_prepare($this->connection,"get_order","SELECT * FROM orders WHERE order_id = $1 ");
        $result = pg_execute($this->connection,"get_order",array($orderId));
        $fetchedResult = pg_fetch_assoc($result);
        return new Order($fetchedResult);

    }

    public function checkOrderOwner($userId,$orderId){
        $result=pg_prepare($this->connection,"check_owner","SELECT items.user_id FROM orders JOIN items ON orders.item_id = items.item_id WHERE orders.order_id = $1 ");
        $result = pg_execute($this->connection,"check_owner",array($orderId));
        $dbUserId = pg_fetch_result($result,0,0);
        if($dbUserId === $userId){
            return true;
        }
        return false;
    }

    public function setStatusToUnderProcess($orderId){
        $result=pg_prepare($this->connection,"to_under_process","UPDATE orders SET order_status = 'under process' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_under_process",array($orderId));
    }
    public function setStatusToDelivery($orderId){
        $result=pg_prepare($this->connection,"to_delivery","UPDATE orders SET order_status = 'delivery' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_delivery",array($orderId));
    }
    public function setStatusToDelivered($orderId){
        $result=pg_prepare($this->connection,"to_delivered","UPDATE orders SET order_status = 'delivered' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_delivered",array($orderId));
    }
    public function setStatusToDeleted($orderId){
        $result=pg_prepare($this->connection,"to_deleted","UPDATE orders SET order_status = 'deleted' WHERE order_id = $1");
        $result = pg_execute($this->connection,"to_deleted",array($orderId));
    }
}