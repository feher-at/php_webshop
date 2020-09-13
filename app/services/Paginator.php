<?php

namespace app\services;

use app\models\Item;
use app\models\Order;

class Paginator extends AbstractServices {

    private int $resultsPerPage = 10;


    public function countData($query,$params = [])
    {
        $result = pg_prepare($this->connection, "count_Data", $query);
        $result = pg_execute($this->connection, "count_Data", $params);
        return pg_fetch_result($result,0,0);
    }

    public function countPages($amountOfData){
        $numberOfPages = ceil($amountOfData/$this->resultsPerPage);
        return $numberOfPages;
    }

    public function getOrders($currentPage,$userId){
        $result = pg_prepare($this->connection, "count_Data", "SELECT * FROM orders WHERE item_id IN (SELECT item_id FROM items WHERE user_id = $1) LIMIT $2 OFFSET $3 ;");
        $offset = ($currentPage -1 )*10;
        $result = pg_execute($this->connection, "count_Data", array($userId,$this->resultsPerPage,$offset));
        $fetchedResult =  pg_fetch_all($result);
        $orderArray = [];
        for($i=0;$i<count($fetchedResult);$i++){
            array_push($orderArray,new Order($fetchedResult[$i]));
        }
        return $orderArray;
    }

    /**
     * Gets all item for the pagination
     * @param $currentPage
     * @return array
     */
    public function getItems($currentPage){
        $result = pg_prepare($this->connection, "count_Data", "SELECT * FROM items LIMIT $1 OFFSET $2 ;");
        $itemsOffset = ($currentPage -1 )*10;
        $result = pg_execute($this->connection, "count_Data", array($this->resultsPerPage,$itemsOffset));
        $fetchedResult =  pg_fetch_all($result);
        $itemArray = [];
        for($i=0;$i<count($fetchedResult);$i++){
            array_push($itemArray,new Item($fetchedResult[$i]));
        }
        return $itemArray;
    }

}
