<?php

namespace app\controllers;

use app\core\Controller;


class HomeController extends Controller
{

    public function getIndex()
    {


        return $this->render('home/home');

    }


}