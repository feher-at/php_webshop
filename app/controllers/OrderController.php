<?php


namespace app\controllers;


use app\Core\Controller;
use app\Core\Request;
use app\services\EmailService;
use app\services\Interfaces\IEmailService;
use app\services\Interfaces\IItemService;
use app\services\Interfaces\IOrderService;
use app\services\Interfaces\IPaymentService;
use app\services\Interfaces\IShippingService;
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

    /**
     * Create the orders with the data what we create from the request what it get,create an email,and send it to the
     * orderer's email andress.
     * @param Request $request
     * @return string|string[]
     */
    public function createTheOrder(Request $request)
    {
        $body = $request->getBody();
        $errors = $this->orderService->orderValidation($body);
        $allOrderInfo = array();

        $allOrderInfo['item_id'] = $body['item_id'];
        $allOrderInfo['payments'] = $this->paymentService->getAllPaymentPriceAndName($body['item_id']);
        $allOrderInfo['couriers'] = $this->shippingService->getAllCouriersToOneItem($body['item_id']);
        $allOrderInfo['price'] = $this->itemService->getGivenItemCurrentPrice($body['item_id']);
        $allOrderInfo['error'] = $errors;
        if(empty($errors))
        {
            $this->orderService->createOrder($this->makeOrderArray($body));
            $userUseTransactionData['data'] = array();
            $this->makeTheEmail($this->makeTheArrayForTheBuyerData($body));
            if($body['payments'] == 'transaction')
                $userUseTransactionData['data'] = $this->getUserTransactionData($body);
                var_dump($userUseTransactionData);
            return $this->render('items/buyerData',$userUseTransactionData);
        }


        return $this->render('items/order',$allOrderInfo);

    }
    /**
     * Returns a user's orders.
    */
    public function getUsersOrders($userId){
        return $this->orderService->getAllOrdersOfUser($userId);
    }

    /**
     * Sets an order's status to under process then returns to the same page of myOrders.
     * @param Request $request
     * Contains the order id and the current page number.
     */
    public function updateOrderStatusUnderProcess(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToUnderProcess($orderId);
        $this->setLayout('layout');
        $this->redirect("/myOrders?page=".$page);
    }
    /**
     * Sets an order's status to delivery then returns to the same page of myOrders.
     * @param Request $request
     * Contains the order id and the current page number.
     */
    public function updateOrderStatusDelivery(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDelivery($orderId);
        $this->setLayout('layout');
        $this->redirect("/myOrders?page=".$page);
    }
    /**
     * Sets an order's status to delivered then returns to the same page of myOrders.
     * @param Request $request
     * Contains the order id and the current page number.
     */
    public function updateOrderStatusDelivered(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDelivered($orderId);
        $this->setLayout('layout');
        $this->redirect("/myOrders?page=".$page);
    }
    /**
     * Sets an order's status to deleted then returns to the same page of myOrders.
     * @param Request $request
     * Contains the order id and the current page number.
     */
    public function updateOrderStatusDeleted(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        $page = $body["currentPage"];
        $this->orderService->setStatusToDeleted($orderId);
        $this->setLayout('layout');
        $this->redirect("/myOrders?page=".$page);

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
        $itemName = $this->itemService->getItemNameById($body['item_id']);
        $paymentPrice = $this->paymentService->getGivenItemGivenPaymentPrice($body['item_id'],$body['payments']);

        $shippingPrice = $this->shippingService->getGivenItemGivenShippingPrice($body['item_id'],$body['couriers']);

        $oneItemPrice = intval($paymentPrice['0']['payment_handlingfee'])
                    + intval($shippingPrice['0']['shipping_price']) + intval($body['price']);


        return array('customer_name' =>$body['first_name']." ".$body['last_name'],
                    'customer_shipping_address' =>$body['customer_shipping_address'],
                    'customer_billing_address' =>$body['customer_billing_address'],
                    'customer_phone' =>$body['customer_phone'],
                    'item_name' =>$itemName['0']['item_name'],
                    'item_current_price' =>$body['price'],
                    'item_quantity' => $body['item_quantity'],
                    'item_courier_and_price' => $body['couriers']. " (". $shippingPrice['0']['shipping_price'] ." FT )",
                    'item_payment_and_price' => $body['payments']. " (". $paymentPrice['0']['payment_handlingfee'] ." FT )",
                    'price' => $body['price'],
                    'final_price' => ($oneItemPrice * intval($body['item_quantity'])),
                    'order_status' => 'order arrived');

    }

    private function getUserTransactionData($body)
    {
        return array_slice($body,-3);
    }

    private function makeTheEmail($dataToTheEmail)
    {
        $message = "Thank you for your ordering!\n \n Your details is the next: \n\n
                    Item name: ".$dataToTheEmail['item_name'] ."\n
                    Quantity: ".$dataToTheEmail['item_quantity'] ."piece(s) \n
                    Costumer Name: ".$dataToTheEmail['customer_name']. "\n
                    Billing Address: ".$dataToTheEmail['customer_billing_address']. "\n
                    Shipping Address: ".$dataToTheEmail['customer_shipping_address']. "\n
                    Phone Number: ".$dataToTheEmail['customer_phone']. "\n
                    Shipping: ".$dataToTheEmail['item_courier_and_price']. "\n
                    Payment: ".$dataToTheEmail['item_payment_and_price']. "\n
                    Item Price: ".$dataToTheEmail['price']. " FT\n
                    Final Price: ".$dataToTheEmail['final_price']. " FT\n
                    Order Status: ".$dataToTheEmail['order_status']. "\n" ;


        $address = 'phptestuser01@gmail.com';
        $subject = 'order';
        $this->emailService->EmailSending($subject,$message,$address);
    }

}