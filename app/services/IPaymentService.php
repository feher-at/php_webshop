<?php


namespace app\services;


interface IPaymentService
{
    public function getAllPaymentMethod();
    public function createPayment($paymentMethodsWithPrices,$itemId);
}