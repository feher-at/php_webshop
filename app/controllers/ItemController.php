<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IItemService;
use app\services\IShippingService;
use app\services\Itemservice;
use app\services\ShippingService;

class ItemController extends Controller
{
    private IItemService $itemService;
    private IShippingService $shippingService;


    public function __construct(){

        $this->itemService = new ItemService();
        $this->shippingService = new ShippingService();
    }

    public function getItemUploadPage()
    {
        $this->setLayout('layout');
     
        return $this->render('items/itemUpload');
    }

    public function uploadItem(Request $request)
    {
        $sessionUserId = $_COOKIE['type'];
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


        $shippersAndPrices = $this->shippingService->returnShippingArrayFromRequest($body);
        $itemError = $this->itemService->itemValidation($itemInfo);
        $shippingError = $this->shippingService->shippingValidation($shippersAndPrices);
        $allErrors = array_merge($itemError,$shippingError);

        if(empty($allErrors)) {
            $this->itemService->uploadItemPictures('Itempictures', $_FILES['item_image']);
            $this->itemService->uploadItemPictures('OGItemPictures', $_FILES['item_ogpicture']);
            $latestUploadedItemId = $this->itemService->uploadItem($itemInfo);
            $shippersWithPrice = $this->shippingService->checkSettedShippers($shippersAndPrices);

            foreach ($shippersWithPrice as $key) {

                $this->shippingService->createShipping($latestUploadedItemId['item_id'], $key);
            }

            $this->redirect('/');
        }
        return $this->render('items/itemUpload',$allErrors);
    }



}