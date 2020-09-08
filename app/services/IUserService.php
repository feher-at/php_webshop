<?php

namespace app\services;

use app\models\User;

interface IUserService
{
    public function registerUser(array $params);

    public function checkUserExists(array $email);

    public function logInUser(array $credentials);

    public function deleteUser($userId);

    public function updateUserConfirmColumn($userID);

    public function registrationValidation(array $validationParams);

    public function getUserByHashedEmail($hashedEmail): User;

    public function getUserById($userId): User;

    public function updateUser($params);

}