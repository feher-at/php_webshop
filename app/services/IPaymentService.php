<?php


namespace app\services;


interface IPaymentService
{
    public function getAllPaymentMethod();
    public function createPayment($itemId,$paymentMethodId,$handlingFee);
}