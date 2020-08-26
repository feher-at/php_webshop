<?php

namespace app\models;

class courier
{
    private int $iD;
    public string $name;

    /**
     * courier constructor.
     * @param int $iD
     */
    public function __construct(int $iD,string $name)
    {
        $this->iD = $iD;
        $this->name = $name;
    }

}