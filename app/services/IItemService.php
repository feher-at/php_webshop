<?php


namespace app\services;


interface IItemService
{
    public function uploadItem(array $params);
    public function updateItem();
    public function getItem();
    public function deleteItem();
    public function getAllCouriers();
    public function uploadItemPictures($itemPicturesSubMap,$file);
}