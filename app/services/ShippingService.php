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

    public function getAllCouriers()
    {
        return pg_fetch_all(pg_query($this->connection, "Select * From couriers"));

    }

    public function getAllCouriersToOneItem(int $itemId): array
    {
        $this->database->reConnect();

        $query = "SELECT couriers.courier_id,couriers.courier_name,shipping_price
                    FROM couriers JOIN shipping ON couriers.courier_id = shipping.courier_id 
                    WHERE item_id = $1";

        return pg_fetch_all(pg_query_params($this->connection,$query,array($itemId)));

    }

    /**
     * Create the shipping pivot table in the data base from the given params
     * @param int $itemId
     * This need to be an existing item id
     * @param array $shippersWithPrices
     * All the shippers with the prices
     */
    public function createShipping(int $itemId, array $shippersWithPrices)
    {
        $this->database->reConnect();
        $query = "INSERT INTO shipping(item_id,courier_id,shipping_price) VALUES($1,$2,$3)";

        pg_query_params($this->connection,$query,array($itemId,
                                                       $shippersWithPrices['courier_id'],
                                                       $shippersWithPrices['price']));

    }

    /**

     *
     * return with the couriers with name,id (if there is any) and the price
     * yeah I know it's ugly but the checkbox array didn't work to me,I tried everything what could I
     * but it still doesn't work so I need to use this ugly code,I don't know it's the browser(google chrome) fault
     * or the php's fault,or I just spoiled something,as soon as I know a solution for this I will rewrite this disgusting code.
     * @param $body
     * An array with the couriers and it's prices
     * @return array
     * Return with the couriers with name,id and the price
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

    /**
     * This function get all the couriers from the array,and it's check if the courier checkbox is checked
     * and the price input is filled or no,if both of them are filled it's create a key value pair from it's
     * data and put in the checkedShippers array and at the end return with it.
     * @param array $shippers all the couriers with it's price fields
     * @return array Return all the couriers which has price as well
     *
     */
    public function checkSettedShippers(array $shippers){
        $checkedShippers = array();

        foreach($shippers as $key => $value)
        {
            if($value['courier'] != null && $value['price'] != ''){
                $checkedShippers[$value['name']] = array('courier_id' => $value['courier'],'price' => $value['price']);
            }
        }

        return $checkedShippers;
    }

    /**
     * Check all the couriers checkbox and it's price field,if one of them is missing then it's create
     * a key value pair with the given couriers error,but it's also create an error when none of the
     * couriers and price field filled.At the end return with all the errors.
     * @param array $shippers A shipper array which waiting for validation.
     * @return array|string[] All the errors which occurs at the validation process
     *
     */
    public function shippingValidation(array $shippers)
    {
        $errors = array();
        $noCourier = 0;

        foreach($shippers as $key =>$value)
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
        if($noCourier == count($shippers))
        {
            return $errors = array('noCouriers' =>'you need to choose one courier at least!');
        }
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {
                return $errors;
            }
        }
        return $errors = array();

    }

    public function getGivenItemGivenShippingPrice($itemId,$courierName)
    {
        $this->database->reConnect();
        $query = "Select shipping.shipping_price from 
                  shipping Join couriers On shipping.courier_id = couriers.courier_id
                  Where couriers.courier_name = $1 and shipping.item_id = $2";
        return pg_fetch_all(pg_query_params($this->connection,$query,array(strtoupper($courierName),$itemId)));
    }
}