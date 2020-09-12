<?php


namespace app\services;



use app\services\Interfaces\IItemService;
use app\models\Item;

class ItemService extends AbstractServices implements IItemService
{



    public function getItemNameById($itemId)
    {

        $this->database->reConnect();
        $query = "SELECT item_name FROM items WHERE item_id = $1";
        return pg_fetch_all(pg_query_params($this->connection,$query,array($itemId)));
    }

    /**
     * Upload the items to the database with the given parameters and return immediately with the item id
     *
     * @param array $params
     * The params for the item upload
     * @return array
     * The given item id
     */

    public function uploadItem(array $params)
    {

        $this->database->reConnect();
        $query= "INSERT INTO items (user_id,item_name,item_description,
                                          item_grossprice,item_image,item_stock,item_saleprice,
                                          item_seoname,item_seodescription,item_ogimage,item_is_buyable)
                                   VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10,$11)";
        $latestItemIdQuery = "SELECT items.item_id FROM items ORDER BY items.item_id DESC LIMIT 1 ";

        $queryArray = array('user_id'=>$params['user_id'],
                            'item_name' => $params['item_name'],
                            'item_description' => $params['item_description'],
                            'item_price' => $params['item_price'],
                            'item_image' =>$params['item_image'],
                            'item_stock' =>$params['item_stock'],
                            'item_saleprice'=>$params['item_saleprice'],
                            'item_seoname' =>$params['item_seoname'],
                            'item_seodescription'=>$params['item_seodescription'],
                            'item_ogimage' => $params['item_ogimage'],
                            'item_is_buyable' => 1);

        pg_query_params($this->connection,$query,$queryArray);

        $result = pg_query($this->connection,$latestItemIdQuery);
        return pg_fetch_assoc($result);

    }



    public function getAllItem():array
    {
        $this->database->reConnect();
        $allItem = array();
        $allItem['allItem'] = array();

        $result = pg_fetch_all(pg_query($this->connection, "Select * From items"));

        if(!empty($result)){
            foreach($result as $item)
            {
                $itemObject = new Item($item);
                $allItem['allItem'][$itemObject->item_name] = $itemObject;

            }
        }

        return $allItem;

    }

    public function getGivenItemCurrentPrice($itemId)
    {
        $this->database->reConnect();
        $query = "SELECT item_grossprice,item_saleprice FROM items WHERE item_id = $1";
        $result =  pg_fetch_array(pg_query_params($this->connection,$query,array($itemId)));
        return $result['item_saleprice'] != 0 ? $result['item_saleprice'] : $result['item_grossprice'];



    }

    /**
     * Upload a given file to the given maps within the ItemPictures,if the ItemPictures map
     * does not exist it will be created.
     * @param $itemPicturesSubMap
     * The map in which you want to upload the file
     * @param $file
     * The file you want to upload

     */
    public function uploadItemPictures($itemPicturesSubMap,$file)
    {

        if (!file_exists(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\public\Pictures'))
        {
        mkdir(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\public\Pictures',0777);
        }
        if(!file_exists(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\public\Pictures\\' .$itemPicturesSubMap)){
            mkdir(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\public\Pictures\\' .$itemPicturesSubMap,0777);
        }
        $uploadDir = dirname($_SERVER['DOCUMENT_ROOT'],1,). '\public\Pictures\\' .$itemPicturesSubMap.'\\'. basename($file['name']);
        move_uploaded_file($file['tmp_name'],$uploadDir);
    }

    /**
     * Validate the item parameters.
     * @param $params
     * The item parameters which wanted to uploading
     * @return array
     * Return all the errors which occurred
     */
    public function itemValidation($params)
    {
        $errors = array();

        $errors['item_name_error'] = Validations::requiredValidation($params['item_name']);
        $errors['item_description_error'] = Validations::requiredValidation($params['item_description']);
        $errors['item_price_error'] = Validations::itemPriceValidation($params['item_price']);
        $errors['item_image_error'] = Validations::requiredValidation($params['item_image']);
        $errors['item_saleprice_error'] = Validations::intValidation($params['item_saleprice']);
        $errors['item_stock_error'] = Validations::intValidation($params['item_stock']);

        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }

        return $errors = array();
    }
    public function getUserItemId($userId){
        $itemId=pg_prepare($this->connection,"get_itemId","SELECT item_id FROM items WHERE user_id = $1 ");
        $itemId = pg_execute($this->connection,"get_itemId",array($userId));
        $itemIdFetch = pg_fetch_all($itemId);
        $itemIds = array();
        if(empty($itemIdFetch)){
            return null;
        }
        for($i=0;$i<count($itemIdFetch);$i++){
            array_push($itemIds,$itemIdFetch[$i]["item_id"]);
        }
        return $itemIds;
    }

    public function deleteItemShipping($userId){

            $shippingDel = pg_prepare($this->connection, "delete_shipping", "DELETE FROM shipping WHERE  shipping.item_id IN (SELECT items.item_id FROM items WHERE items.user_id = $1);");
            $shippingDel = pg_execute($this->connection, "delete_shipping", array($userId));



    }

    public function deleteItemsOfUser($userId){

            $itemsDel = pg_prepare($this->connection, "delete_items", "DELETE FROM items WHERE user_id = $1;");
            $itemsDel = pg_execute($this->connection, "delete_items", array($userId));



    }
    public function setBuyableInDb($state,$itemId){

        $itemsDel = pg_prepare($this->connection, "update_buyable", "UPDATE items SET item_is_buyable = $1 WHERE item_id = $2;");
        $state = ($state) ? 'f':'t';
        $itemsDel = pg_execute($this->connection, "update_buyable", array($state,$itemId));
    }


    public function deleteItem()
    {
        // TODO: Implement deleteItem() method.
    }

}