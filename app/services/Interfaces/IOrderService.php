<?php


namespace app\services\Interfaces;


interface IOrderService
{
    public function getAllOrdersOfUser($userId);
    public function createOrder(array $orderParams);
    public function getOrderById($orderId);
    public function checkOrderOwner($userId,$orderId);
}