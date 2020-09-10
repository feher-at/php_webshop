<?php


namespace app\services;


interface IPaymentService
{
    public function getAllPayment($itemId);
    public function getAllPaymentMethod();
    public function createPayment($itemId,$paymentMethodId,$handlingFee);
    public function getAllPaymentPriceAndName($itemId);
    public function getGivenItemGivenPaymentPrice($itemId,$paymentMethodName);
}