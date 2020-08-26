<?php

namespace app\services;

interface IUserService
{
    public function registerUser();

    public function checkUserExits();

    public function deleteUser();

    public function updateUser();
}