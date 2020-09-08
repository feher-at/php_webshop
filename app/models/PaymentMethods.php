<?php

namespace app\models;



class paymentMethods
{
    private int $payment_method_id;
    private string $payment_method_name;


    public function __construct($paymentMethodId,$paymentMethodName)
    {
        $this->payment_method_id = $paymentMethodId;
        $this->payment_method_name = $paymentMethodName;
    }

}