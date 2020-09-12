<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\Interfaces\IItemService;
use app\services\Interfaces\IPaymentService;
use app\services\Interfaces\IShippingService;
use app\services\Itemservice;
use app\services\PaymentService;
use app\services\ShippingService;

class ItemController extends Controller
{
    private IItemService $itemService;
    private IShippingService $shippingService;
    private IPaymentService $paymentService;


    public function __construct(){

        $this->itemService = new ItemService();
        $this->shippingService = new ShippingService();
        $this->paymentService = new PaymentService();
    }

    public function getItemUploadPage()
    {

        $this->setLayout('layout');
        $paymentMethods['payments'] = $this->paymentService->getAllPaymentMethod();


     
        return $this->render('items/itemUpload',$paymentMethods);
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
        $allPaymentMethod['payments'] = $this->paymentService->getAllPaymentMethod();
        $allRequiredData['errors'] = array_merge($itemError,$shippingError);
        $allRequiredData = array_merge($allRequiredData,$allPaymentMethod);

        if(empty($allRequiredData['errors'])) {
            $this->itemService->uploadItemPictures('ItemPictures', $_FILES['item_image']);
            $this->itemService->uploadItemPictures('OGItemPictures', $_FILES['item_ogpicture']);
            $latestUploadedItemId = $this->itemService->uploadItem($itemInfo);
            $paymentArray = $this->makePaymentArray($body,$latestUploadedItemId['item_id']);
            $this->makeThePaymentRowFromPaymentArray($paymentArray);
            $shippersWithPrice = $this->shippingService->checkSettedShippers($shippersAndPrices);


            foreach ($shippersWithPrice as $key) {

                $this->shippingService->createShipping($latestUploadedItemId['item_id'], $key);
            }

            $this->redirect('/');


        }
        return $this->render('items/itemUpload',$allRequiredData);
    }


    private function makeTheItemInfoArray(array $body)
    {
          $sessionUser = $_COOKIE['type'];
          return array( 'user_id'=>$sessionUser,
                        'item_name' => $body['item_name'],
                        'item_description' => $body['item_description'],
                        'item_price' => $body['item_price'],
                        'item_image' =>basename($_FILES['item_image']['name']),
                        'item_stock' =>$body['item_stock'] ? $body['item_stock'] : 0,
                        'item_saleprice'=>$body['item_saleprice'] ? $body['item_saleprice'] : 0,
                        'item_seoname' =>$body['item_seoname'] ? $body['item_seoname']:"",
                        'item_seodescription'=>$body['item_seodescription'] ? $body['item_seodescription'] : "" ,
                        'item_ogimage' => basename($_FILES['item_ogpicture']['name']) ? basename($_FILES['item_ogpicture']['name']) : "" );


    }

    private function makePaymentArray(array $body,$item_id)
    {
        $payments = array();
        $allPaymentMethod = $this->paymentService->getAllPaymentMethod();
        foreach($allPaymentMethod as $payment)
        {
            $paymentMethodName = str_replace(" ","_",$payment['payment_method_name']);
            $payments[$payment['payment_method_name']] = array('item_id' => $item_id,
                                                            'payment_method_id' => $payment['payment_method_id'],
                                                            'payment_handlingfee' =>$body[$paymentMethodName.'_price']);
        }
        return $payments;
    }

    private function makeThePaymentRowFromPaymentArray(array $paymentArray)
    {
        foreach ($paymentArray as $payment)
        {
            $this->paymentService->createPayment($payment['item_id'],$payment['payment_method_id'],$payment['payment_handlingfee']);
        }
    }




}