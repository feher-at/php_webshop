<?php


namespace app\services;


interface IShippingService
{
    public function createShipping(int $itemId,array $shippersWithPrices);

}