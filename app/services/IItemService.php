<?php


namespace app\services;


interface IItemService
{
    public function uploadItem(array $params);
    public function updateItem();
    public function getAllItem();
    public function deleteItem();
    public function uploadItemPictures($itemPicturesSubMap,$file);
}