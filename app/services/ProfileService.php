<?php
namespace app\services;
use app\Core\Request;
use app\models\User;
use app\services\UserService;

class ProfileService implements IProfileService{
    public function __construct()
    {
        $this->userService = new UserService();
    }
    public function getUser() : User{
        return $this->userService->getUserById($_COOKIE["type"]);

    }
    public function updateProfile($params){
        $this->userService->updateUser($params);
    }
}