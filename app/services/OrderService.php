<?php


namespace app\services;


class OrderService implements IOrderService
{

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

    public function getAllOrdersOfUser($userId){
        $result=pg_prepare($this->connection,"get_orders","SELECT * FROM orders WHERE item_id IN (SELECT item_id FROM items WHERE user_id = $1) ");
        $result = pg_execute($this->connection,"get_orders",array($userId));
        return pg_fetch_all($result);

    }
}