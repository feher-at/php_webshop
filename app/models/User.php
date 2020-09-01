<?php


namespace app\models;

class User
{


    public int $user_id;
    public string $user_email;
    public int $user_taxnum;
    public string $user_password;
    public bool $confirmed;
    public string $hashed_email_for_validation;

    /**
     * @return string
     */
    public function getHashedEmailForValidation(): string
    {
        return $this->hashed_email_for_validation;
    }

    /**
     * @param string $hashedEmailForValidation
     */
    public function setHashedEmailForValidation(string $hashed_email_for_validation): void
    {
        $this->hashed_email_for_validation = hashed_email_for_validation;
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