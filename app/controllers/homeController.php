<?php

namespace app\controllers;

use app\core\Controller;

class homeController extends Controller
{
    public function getIndex()
    {
        $params = [
            'name' => "anyádpicsája"
        ];
        return $this->render('home/home',$params);

    }


}