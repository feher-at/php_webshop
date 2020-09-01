<?php


namespace app\services;


interface IItemService
{
    public function uploadItem();
    public function updateItem();
    public function getItem();
    public function deleteItem();
}