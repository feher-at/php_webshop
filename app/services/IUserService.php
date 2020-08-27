<?php

namespace app\services;

interface IUserService
{
    public function registerUser(array $params);

    public function checkUserExits();

    public function deleteUser();

    public function updateUser();
}