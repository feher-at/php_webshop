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
        var_dump($allInfoForOrder);

        return $this->render('items/order',$allInfoForOrder);
    }

    public function getUsersOrders(){
        return $this->orderService->getAllOrdersOfUser($_COOKIE['type']);
    }

}