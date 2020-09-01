<?php

namespace app\services;

interface IUserService
{
    public function registerUser(array $params);

    public function checkUserExists(array $email);

    public function logInUser(array $credentials);

    public function deleteUser();

    public function updateUser();

    public function getTheLatestRegisteredUser();
}