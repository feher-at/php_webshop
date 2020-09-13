<?php

namespace app\controllers;

use app\Core\Controller;
use app\services\Interfaces\IItemService;
use app\services\ItemService;
use app\services\Paginator;
use app\Core\Request;


class HomeController extends Controller
{
    private IItemService $itemService;
    private Paginator $paginator;


    public function __construct()
    {
        $this->itemService = new ItemService();
        $this->paginator = new Paginator();
    }

    public function getIndex(Request $request)
    {
        $body = $request->getBody();
        $allItem = $this->itemService->getAllItem();
        if(!empty($allItem['allItem'])) {
            if (!isset($body["page"])) {
                $currentPage = 1;
            } else {
                $currentPage = $body["page"];
            }
            $numberOfPages = $this->paginator->countPages(count($allItem['allItem']));
            if ($currentPage > $numberOfPages || $currentPage <= 0 || $currentPage == null) {
                return $this->render('404_page');
            }
            $items['items'] = $this->paginator->getItems($currentPage);
            $items['pages'] = $numberOfPages;
            $items['current_page'] = $currentPage;
            return $this->render('home/home', $items);
        }
        return $this->render('home/home');

    }


}