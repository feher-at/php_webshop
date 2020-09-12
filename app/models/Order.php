<?php

namespace app\models;

class Order
{
    public int $order_id;
    public string $customer_name;
    public string $customer_shipping_address;
    public string $customer_billing_address;
    public string $customer_phone;
    public string $customer_email;
    public int $item_id;
    public int $item_current_price;
    public int $item_quantity;
    public string $order_status;

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