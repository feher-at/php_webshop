<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IItemService;
use app\services\IOrderService;
use app\services\IPaymentService;
use app\services\IShippingService;
use app\services\ItemService;
use app\services\OrderService;
use app\services\PaymentService;
use app\services\ShippingService;



class OrderController extends Controller
{
    private IShippingService $shippingService;
    private IItemService $itemService;
    private IOrderService $orderService;
    private IPaymentService $paymentService;

    public function __construct()
    {
        $this->shippingService = new ShippingService();
        $this->itemService = new ItemService();
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
    }
    public function getOrderPage(Request $request)
    {
        $itemId = $request->getBody();
        $allInfoForOrder = array();
        $allInfoForOrder['item_id'] = $itemId['item_id'];
        $allInfoForOrder['payments'] = $this->paymentService->getAllPaymentPriceAndName($itemId['item_id']);
        $allInfoForOrder['couriers'] = $this->shippingService->getAllCouriersToOneItem($itemId['item_id']);
        $allInfoForOrder['price'] = $this->itemService->getGivenItemCurrentPrice($itemId['item_id']);
        var_dump($allInfoForOrder);
        return $this->render('items/order',$allInfoForOrder);
    }

    public function createTheOrder(Request $request)
    {
        $body = $request->getBody();
        $this->orderService->createOrder($this->makeOrderArray($body));
        var_dump($this->makeTheArrayForTheBuyerData($body));
        return $this->render('items/buyerData');

    }

    private function makeOrderArray($body)
    {
       return array('customer_name' =>$body['first_name']." ".$body['last_name'],
                    'customer_shipping_address' =>$body['customer_shipping_address'],
                    'customer_billing_address' =>$body['customer_billing_address'],
                    'customer_phone' =>$body['customer_phone'],
                    'customer_email' =>$body['customer_email'],
                    'item_id' =>$body['item_id'],
                    'item_current_price' =>$body['price'],
                    'item_quantity' => $body['item_quantity'],
                    'order_status' => 'order arrived');

    }
    private function makeTheArrayForTheBuyerData($body)
    {
        $PaymentPrice = intval($this->paymentService->getGivenItemGivenPaymentPrice($body['item_id'],$body['payments']));
        $ShippingPrice = intval($this->shippingService->getGivenItemGivenShippingPrice($body['item_id'],$body['payments']));
        $finalPrice = $PaymentPrice + $ShippingPrice + intval($body['price']);
        if($body['payments']!= "transaction")
        {
            return array('customer_name' =>$body['first_name']." ".$body['last_name'],
                        'customer_shipping_address' =>$body['customer_shipping_address'],
                        'customer_billing_address' =>$body['customer_billing_address'],
                        'customer_phone' =>$body['customer_phone'],
                        'customer_email' =>$body['customer_email'],
                        'item_id' =>$body['item_id'],
                        'item_current_price' =>$body['price'],
                        'item_quantity' => $body['item_quantity'],
                        'order_status' => 'order arrived',
                        'price' => $finalPrice);
        }
    }
    public function getUsersOrders($userId){
        return $this->orderService->getAllOrdersOfUser($userId);
    }

}