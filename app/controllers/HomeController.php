<?php

namespace app\controllers;

use app\core\Controller;
use app\services\IItemService;
use app\services\ItemService;


class HomeController extends Controller
{
    private IItemService $itemService;

    public function __construct()
    {
        $this->itemService = new ItemService();
    }

    public function getIndex()
    {

        $items = $this->itemService->getAllItem();


        return $this->render('home/home',$items);

    }


}