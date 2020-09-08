<?php


namespace app\services;


interface IOrderService
{
    public function getAllOrder();
    public function updateOrder();
    public function deleteOrder();
    public function createOrder(array $orderParams);
}