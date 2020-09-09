<?php

namespace app\models;

class Order
{
    private int $order_id;
    private string $customer_name;
    private string $customer_shipping_address;
    private string $customer_billing_address;
    private int $customer_phone;
    private string $customer_email;
    private int $item_id;
    private int $item_current_price;
    private int $item_quantity;

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