<?php

namespace app\models;

class Order
{
    private int $orderId;
    private string $customerName;
    private string $customerShippingAddress;
    private string $customerBillingAddress;
    private int $customerPhone;
    private string $customerEmail;
    private int $itemId;
    private int $itemQuantity;

    /**
     * Order constructor.
     * @param array $args

     */
    public function __construct(array $args)
    {
        foreach($args as $key=> $val){
            $this->$key = $val;
        }
    }


}