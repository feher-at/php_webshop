<?php


namespace app\services;


use app\models\Item;

class ItemService implements IItemService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
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

        if($this->connection){
            pg_query_params($this->connection,$query,$queryArray);

            $result = pg_query($this->connection,$latestItemIdQuery);
            return pg_fetch_assoc($result);
        }
        else{
            $this->database->reConnect();
            pg_query_params($this->connection,$query,$queryArray);

            $result = pg_query($this->connection,$latestItemIdQuery);
            return pg_fetch_assoc($result);
        }
    }

    public function updateItem()
    {
        // TODO: Implement updateItem() method.
    }

    public function getAllItem():array
    {
        $allItem = array();
        $allItem['allItem'] = array();

        $result = pg_fetch_all(pg_query($this->connection, "Select * From items"));

        foreach($result as $item)
        {
            $itemObject = new Item($item);
            $allItem['allItem'][$itemObject->item_name] = $itemObject;

        }
        return $allItem;

    }

    public function deleteItem()
    {
        // TODO: Implement deleteItem() method.
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
}