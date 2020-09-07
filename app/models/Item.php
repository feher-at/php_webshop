<?php

namespace app\models;

class Item
{
    public int $item_id;
    public int $user_id;
    public string $item_name;
    public string $item_description;
    public int $item_grossprice;
    public string $item_image;
    public int $item_stock;
    public int $item_saleprice;
    public string $item_seoname;
    public string $item_seodescription;
    public string $item_ogimage;
    public bool $item_is_buyable;



    /**
     * Item constructor.
     * @param array $args
     *
     */
    public function __construct(array $args)
    {
        foreach($args as $key => $val){
            $this->$key = $val;
        }
    }


}