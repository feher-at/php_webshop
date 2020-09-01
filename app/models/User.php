<?php


namespace app\models;

class User
{


    public int $iD;
    public string $email;
    public int $taxNumber;
    public string $password;
    public bool $confirmed;
    public string $hashedEmailForValidation;

    /**
     * @return string
     */
    public function getHashedEmailForValidation(): string
    {
        return $this->hashedEmailForValidation;
    }

    /**
     * @param string $hashedEmailForValidation
     */
    public function setHashedIdForValidation(string $hashedEmailForValidation): void
    {
        $this->hashedEmailForValidation = $hashedEmailForValidation;
    }


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