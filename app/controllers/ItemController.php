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

    /**
     * This function upload an item in the database with the given data from the body
     * and it's also creating all the column in the item-couriers (shipping) pivot table,
     * if there is no error.
     * Else it's return to the itemUpload page with all the errors,to warns users to the miss
     * typing or the required fields
     * @param Request $request
     * The request which the user send to the server it's contains all the required data
     * @return string|string[]
     * Return to the itemUpload page with the errors if there any.
     */
    public function uploadItem(Request $request)
    {

        $body = $request->getBody();
        $itemInfo = $this->makeTheItemInfoArray($body);

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


    private function makeTheItemInfoArray(array $body)
    {
          $sessionUser = $_COOKIE['type'];
          return array( 'user_id'=>$sessionUser,
                        'item_name' => $body['item_name'],
                        'item_description' => $body['item_description'],
                        'item_price' => $body['item_price'],
                        'item_image' =>basename($_FILES['item_image']['name']),
                        'item_stock' =>$body['item_stock'],
                        'item_saleprice'=>$body['item_saleprice'],
                        'item_seoname' =>$body['item_seoname'],
                        'item_seodescription'=>$body['item_seodescription'],
                        'item_ogimage' => basename($_FILES['item_ogpicture']['name']));


    }



}