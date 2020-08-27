<?php


namespace app\models;

class User
{


    public int $iD;
    public string $email;
    public int $taxNumber;
    public string $password;
    public bool $confirmed;

    /**
     * User constructor.
     * @param array $args
     */
    public function __construct(array $args)
    {
        foreach ($args as $key=>$value){
            $this->$key = $value;
        }
    }

}