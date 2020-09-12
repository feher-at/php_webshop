<?php


namespace app\services;


interface IItemService
{
    public function uploadItem(array $params);
    public function getItemNameById($itemId);
    public function getAllItem();
    public function deleteItem();
    public function uploadItemPictures($itemPicturesSubMap,$file);
    public function deleteItemShipping($userId);
    public function deleteItemsOfUser($userId);
}