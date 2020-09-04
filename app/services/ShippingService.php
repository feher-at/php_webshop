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
    public function CheckSettedShippers(array $body){
        $checkedShippers = array();
        if(isset($body['gls']) && isset($body['gls_price'])){
            $checkedShippers[$body['gls']] = array('courier_id' => $body['gls'],'price' => $body['gls_price']);
        }
        if(isset($body['dpd']) && isset($body['dpd_price'])){
            $checkedShippers[$body['dpd']] = array('courier_id' => $body['dpd'],'price' => $body['dpd_price']);
        }
        if(isset($body['personal_receive']) && isset($body['personal_receive_price'])){
            $checkedShippers[$body['personal_receive']] = array('courier_id' => $body['personal_receive'],'price' => $body['personal_receive_price']);
        }
        if(isset($body['magyar_posta']) && isset($body['magyar_posta_price'])){
            $checkedShippers[$body['magyar_posta']] = array('courier_id' => $body['magyar_posta'],'price' => $body['magyar_posta_price']);
        }
        if(isset($body['fox_post']) && isset($body['fox_post_price'])){
            $checkedShippers[$body['fox_post']] = array('courier_id' => $body['fox_post'],'price' => $body['fox_post_price']);
        }

        return $checkedShippers;
    }
}