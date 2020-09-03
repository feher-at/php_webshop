<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IItemService;
use app\services\Itemservice;

class ItemController extends Controller
{
    private IItemService $itemService;


    public function __construct(){

        $this->itemService = new ItemService();
    }

    public function getItemUploadPage()
    {
        $this->setLayout('layout');
        $result = $this->itemService->getAllCouriers();
        $allCouriers = array('allCouriers' => $result);
        return $this->render('items/itemUpload',$allCouriers);
    }

    public function uploadItem(Request $request)
    {
        $sessionUserId = $_COOKIE['type'];
        var_dump($sessionUserId);
        $body = $request->getBody();
        $itemInfo = array('user_id'=>$sessionUserId,
                          'item_name' => $body['item_name'],
                          'item_description' => $body['item_description'],
                          'item_price' => $body['item_price'],
                          'item_image' =>basename($_FILES['item_image']['name']),
                          'item_stock' =>$body['item_stock'],
                          'item_saleprice'=>$body['item_saleprice'],
                          'item_seoname' =>$body['item_seoname'],
                          'item_seodescription'=>$body['item_seodescription'],
                          'item_ogimage' => basename($_FILES['item_ogpicture']['name']));

        var_dump($itemInfo);
        $this->itemService->uploadItem($itemInfo);
        $this->itemService->uploadItemPictures('Itempictures',$_FILES['item_image']);
        $this->itemService->uploadItemPictures('OGItemPictures',$_FILES['item_ogpicture']);


        return $this->render('items/itemUpload');
    }



}