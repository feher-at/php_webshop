<?php

namespace app\models;

class Item
{
    private int $iD;
    private int $userID;
    private string $itemName;
    private string $itemDescription;
    private int $itemGrossPrice;
    private string $itemImage;
    private int $salePrice;
    private string $seoName;
    private string $seoDescription;
    private string $ogImage;
    private int $itemCourier;
    private string $status;

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