<?php


namespace app\services\Interfaces;


interface IShippingService
{
    public function createShipping(int $itemId,array $shippersWithPrices);
    public function getAllCouriersToOneItem(int $itemId);

}