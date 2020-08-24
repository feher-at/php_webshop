<?php


class homeController extends Controller
{
    public function index($id='', $name=''){

        //echo 'I am in the'. __CLASS__. 'method '. __METHOD__;

        echo 'Id is: ' .$id . 'and Name is : '. $name;
    }

    public function aboutUs(){
        echo 'I am in the'. __CLASS__. 'method '. __METHOD__;
    }
}