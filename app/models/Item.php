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
     * @param int $iD
     * @param int $userID
     * @param string $itemName
     * @param string $itemDescription
     * @param int $itemGrossPrice
     * @param string $itemImage
     * @param int $salePrice
     * @param string $seoName
     * @param string $seoDescription
     * @param string $ogImage
     * @param int $itemCourier
     * @param string $status
     */
    public function __construct(int $iD, int $userID, string $itemName, string $itemDescription, int $itemGrossPrice, string $itemImage, int $salePrice, string $seoName, string $seoDescription, string $ogImage, int $itemCourier, string $status)
    {
        $this->iD = $iD;
        $this->userID = $userID;
        $this->itemName = $itemName;
        $this->itemDescription = $itemDescription;
        $this->itemGrossPrice = $itemGrossPrice;
        $this->itemImage = $itemImage;
        $this->salePrice = $salePrice;
        $this->seoName = $seoName;
        $this->seoDescription = $seoDescription;
        $this->ogImage = $ogImage;
        $this->itemCourier = $itemCourier;
        $this->status = $status;
    }


}