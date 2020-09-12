<?php
namespace app\services\Interfaces;

use app\models\User;

interface IProfileService{
    public function getUser() : User;
    public function updateProfile($params);
    public function updateValidation(array $validationParams);
}