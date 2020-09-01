<?php


namespace app\controllers;


use app\core\Controller;
use app\Core\Request;

class ItemController extends Controller
{

    public function getItemUploadPage()
    {
        $this->setLayout('layout');
        return $this->render('items/itemUpload');
    }

}