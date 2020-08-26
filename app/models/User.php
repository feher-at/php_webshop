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
     * @param string $userName
     * @param int $iD
     * @param string $email
     * @param int $taxNumber
     * @param string $password
     * @param bool $confirmed
     */
    public function __construct(int $iD, string $email, int $taxNumber, string $password, bool $confirmed)
    {

        $this->iD = $iD;
        $this->email = $email;
        $this->taxNumber = $taxNumber;
        $this->password = $password;
        $this->confirmed = $confirmed;
    }

}