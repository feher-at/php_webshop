<?php

namespace app\controllers;

use app\core\Controller;

class HomeController extends Controller
{
    public function getIndex()
    {

        $params = [
            'name' => "hy"
        ];
        return $this->render('home/home',$params);

    }


}