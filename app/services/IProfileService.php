<?php
namespace app\services;

use app\models\User;

interface IProfileService{
    public function getUser() : User;
}