<?php


namespace app\models;


class Shipping
{
    private int $item_id;
    private int $courier_id;
    private int $shipping_price;

    public function __construct($item_id,$courier_id,$shipping_price)
    {
        $this->item_id = $item_id;
        $this->courier_id = $courier_id;
        $this->shipping_price = $shipping_price;
    }
}