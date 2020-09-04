<?php


namespace app\services;


interface IShippingService
{
    public function createShipping($itemId,$shippersWithPrices);

}