<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;
use app\services\IItemService;
use app\services\IOrderService;
use app\services\IShippingService;
use app\services\ItemService;
use app\services\OrderService;
use app\services\ShippingService;



class OrderController extends Controller
{
    private IShippingService $shippingService;
    private IItemService $itemService;
    private IOrderService $orderService;

    public function __construct()
    {
        $this->shippingService = new ShippingService();
        $this->itemService = new ItemService();
        $this->orderService = new OrderService();
    }
    public function getOrderPage(Request $request)
    {
        $itemId = $request->getBody();
        $allInfoForOrder = array();
        $allInfoForOrder['item_id'] = $itemId['item_id'];
        $allInfoForOrder['couriers'] = $this->shippingService->getAllCouriersToOneItem($itemId['item_id']);
        $allInfoForOrder['price'] = $this->itemService->getGivenItemCurrentPrice($itemId['item_id']);
        var_dump($allInfoForOrder);
        return $this->render('items/order',$allInfoForOrder);
    }

    public function createTheOrder(Request $request)
    {
        $body = $request->getBody();
        var_dump($body);
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

}