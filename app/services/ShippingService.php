<?php


namespace app\services;


class ShippingService implements IShippingService
{

    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    public function createShipping($itemId,$shippersWithPrices)
    {
        $query = "INSERT INTO shipping(item_id,courier_id,shipping_price) VALUES($1,$2,$3)";

        if($this->connection){

            pg_query_params($this->connection,$query,array($itemId,
                                                           $shippersWithPrices['courier_id'],
                                                           $shippersWithPrices['price']));

        }
    }

    /**
     * @param $body
     * @return array
     *
     * return with the couriers with name id (if there is any) and the price
     * yeah i know it's ugly but the checkbox array didn't work to me,i try everything what can i
     * but it still doesn't work so i need to use this ugly code,I don't know it's the browser(google chrome) fault
     * or the php has a bug,as soon as i know a solution for this i will rewrite this disgusting code.
     */
    public function returnShippingArrayFromRequest($body)
    {
        $shippers = array();

        if(isset($body['gls']))
        {
            $shippers['gls'] = array('name'=> 'gls','courier' =>$body['gls'],'price' => $body['gls_price']);
        }
        elseif (!isset($body['gls']))
        {
            $shippers['gls'] = array('name'=> 'gls','courier' => null,'price' => $body['gls_price']);
        }
        if(isset($body['dpd']))
        {
            $shippers['dpd'] = array('name'=> 'dpd','courier' =>$body['dpd'],'price' => $body['dpd_price']);
        }
        elseif (!isset($body['dpd']))
        {
            $shippers['dpd'] = array('name'=> 'dpd','courier' => null,'price' => $body['dpd_price']);
        }
        if(isset($body['personal_receive']))
        {
            $shippers['personal_receive'] = array('name'=> 'personal_receive','courier' =>$body['personal_receive'],'price' => $body['personal_receive_price']);
        }
        elseif (!isset($body['personal_receive']))
        {
            $shippers['personal_receive'] = array('name'=> 'personal_receive','courier' => null,'price' => $body['personal_receive_price']);
        }
        if(isset($body['magyar_posta']))
        {
            $shippers['magyar_posta'] = array('name'=> 'magyar_posta','courier' =>$body['magyar_posta'],'price' => $body['magyar_posta_price']);
        }
        elseif (!isset($body['magyar_posta']))
        {
            $shippers['magyar_posta'] = array('name'=> 'magyar_posta','courier' => null,'price' => $body['magyar_posta_price']);
        }
        if(isset($body['fox_post']))
        {
            $shippers['fox_post'] = array('name'=> 'fox_post','courier' =>$body['fox_post'],'price' => $body['fox_post_price']);
        }
        elseif (!isset($body['fox_post']))
        {
            $shippers['fox_post'] = array('name'=> 'fox_post','courier' => null,'price' => $body['fox_post_price']);
        }

        return $shippers;

    }

    public function checkSettedShippers(array $body){
        $checkedShippers = array();

        foreach($body as $key => $value)
        {
            if($value['courier'] != null && $value['price'] != ''){
                $checkedShippers[$value['name']] = array('courier_id' => $value['courier'],'price' => $value['price']);
            }
        }

        return $checkedShippers;
    }

    public function shippingValidation(array $body)
    {
        $errors = array();
        $noCourier = 0;

        foreach($body as $key =>$value)
        {


            if($value['courier'] === null && $value['price'] === '')
            {
                $noCourier += 1;
                continue;

            }
            elseif($value['courier'] === null || $value['price'] === '')
            {

                $errors[$value['name']] = Validations::shippingValidation($value['courier'],$value['price']);
            }

        }

        /*if($noCourier == count($body))
        {
            return $errors['zero_courier'] = 'you need to choose one courier at least!';
        }*/
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = array();

    }
}