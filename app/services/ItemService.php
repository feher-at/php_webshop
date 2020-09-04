<?php


namespace app\services;


class ItemService implements IItemService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    public function uploadItem(array $params)
    {
        $query= "INSERT INTO items (user_id,item_name,item_description,
                                          item_grossprice,item_image,item_stock,item_saleprice,
                                          item_seoname,item_seodescription,item_ogimage)
                                   VALUES($1,$2,$3,$4,$5,$6,$7,$8,$9,$10)";
        $latestItemIdQuery = "SELECT items.item_id FROM items ORDER BY items.item_id DESC LIMIT 1 ";

        if($this->connection){
            pg_query_params($this->connection,$query,array('user_id'=>$params['user_id'],
                                                           'item_name' => $params['item_name'],
                                                           'item_description' => $params['item_description'],
                                                           'item_price' => $params['item_price'],
                                                           'item_image' =>$params['item_image'],
                                                           'item_stock' =>$params['item_stock'],
                                                           'item_saleprice'=>$params['item_saleprice'],
                                                           'item_seoname' =>$params['item_seoname'],
                                                           'item_seodescription'=>$params['item_seodescription'],
                                                           'item_ogimage' => $params['item_ogimage']));

            $result = pg_query($this->connection,$latestItemIdQuery);
            return pg_fetch_assoc($result);
        }
        else{
            $this->database->reConnect();
            pg_query_params($this->connection,$query,array('user_id'=>$params['user_id'],
                                                           'item_name' => $params['item_name'],
                                                           'item_description' => $params['item_description'],
                                                           'item_price' => $params['item_price'],
                                                           'item_image' =>$params['item_image'],
                                                           'item_stock' =>$params['item_stock'],
                                                           'item_saleprice'=>$params['item_saleprice'],
                                                           'item_seoname' =>$params['item_seoname'],
                                                           'item_seodescription'=>$params['item_seodescription'],
                                                           'item_ogimage' => $params['item_ogimage']));

            $result = pg_query($this->connection,$latestItemIdQuery);
            return pg_fetch_assoc($result);
        }
    }

    public function updateItem()
    {
        // TODO: Implement updateItem() method.
    }

    public function getItem()
    {
        // TODO: Implement getItem() method.
    }

    public function deleteItem()
    {
        // TODO: Implement deleteItem() method.
    }

    public function getAllCouriers()
    {
       return pg_fetch_all(pg_query($this->connection, "Select * From couriers"));

    }

    public function uploadItemPictures($itemPicturesSubMap,$file)
    {
        if (!file_exists(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\ItemPictures'))
        {
        mkdir(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\ItemPictures',0777);
        }
        if(!file_exists(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\ItemPictures\\' .$itemPicturesSubMap)){
            mkdir(dirname($_SERVER['DOCUMENT_ROOT'],1,). '\ItemPictures\\' .$itemPicturesSubMap,0777);
        }
        $uploadDir = dirname($_SERVER['DOCUMENT_ROOT'],1,). '\ItemPictures\\' .$itemPicturesSubMap.'\\'. basename($file['name']);
        move_uploaded_file($file['tmp_name'],$uploadDir);
    }
}