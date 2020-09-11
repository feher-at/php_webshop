<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\EmailService;
use app\services\IEmailService;
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
    private IEmailService  $emailService;

    public function __construct()
    {
        $this->shippingService = new ShippingService();
        $this->itemService = new ItemService();
        $this->orderService = new OrderService();
        $this->paymentService = new PaymentService();
        $this->emailService = new EmailService();
    }
    public function getOrderPage(Request $request)
    {
        $itemId = $request->getBody();
        $allInfoForOrder = array();
        $allInfoForOrder['item_id'] = $itemId['item_id'];
        $allInfoForOrder['payments'] = $this->paymentService->getAllPaymentPriceAndName($itemId['item_id']);
        $allInfoForOrder['couriers'] = $this->shippingService->getAllCouriersToOneItem($itemId['item_id']);
        $allInfoForOrder['price'] = $this->itemService->getGivenItemCurrentPrice($itemId['item_id']);

        return $this->render('items/order',$allInfoForOrder);
    }

    public function createTheOrder(Request $request)
    {
        $body = $request->getBody();
        $this->orderService->createOrder($this->makeOrderArray($body));
        $userUseTransactionData['data'] = array();
        if($body['payments'] == 'transaction')
            $userUseTransactionData['data'] = $this->getUserTransactionData($body);
        return $this->render('items/buyerData',$userUseTransactionData);

    }
    public function getUsersOrders($userId){
        return $this->orderService->getAllOrdersOfUser($userId);
    }


    public function getOneOrder($orderId){
        return $this->orderService->getOrderById($orderId);
    }
    public function checkOrderOwner($userId,$orderId){
        return $this->orderService->checkOrderOwner($userId,$orderId);
    }
    public function updateOrderStatusUnderProcess(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToUnderProcess($orderId);
        $this->setLayout('layout');
        return $this->redirect("/myOrders?page=".$page);
    }
    public function updateOrderStatusDelivery(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDelivery($orderId);
        $this->setLayout('layout');
        return $this->redirect("/myOrders?page=".$page);
    }
    public function updateOrderStatusDelivered(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDelivered($orderId);
        $this->setLayout('layout');
        return $this->redirect("/myOrders?page=".$page);
    }
    public function updateOrderStatusDeleted(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDeleted($orderId);
        $this->setLayout('layout');
        return $this->redirect("/myOrders?page=".$page);

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

        $paymentPrice = $this->paymentService->getGivenItemGivenPaymentPrice($body['item_id'],$body['payments']);
        $shippingPrice = $this->shippingService->getGivenItemGivenShippingPrice($body['item_id'],$body['couriers']);
        $finalPrice = intval($paymentPrice['0']['payment_handlingfee'])
                    + intval($shippingPrice['0']['shipping_price']) + intval($body['price']);


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

    private function getUserTransactionData($body)
    {
        return array_slice($body,-3);
    }

    private function makeTheEmail($dataToTheEmail)
    {

    }

}