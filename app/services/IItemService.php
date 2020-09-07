<?php


namespace app\services;


interface IItemService
{
    public function uploadItem(array $params);
    public function updateItem();
    public function getItem();
    public function deleteItem();
    public function uploadItemPictures($itemPicturesSubMap,$file);
    public function deleteItemShipping($userId);
    public function deleteItemsOfUser($userId);
}