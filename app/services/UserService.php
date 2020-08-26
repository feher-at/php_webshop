<?php

namespace app\services;

class UserService implements IUserService
{
    private IDatabaseService $dbService;

    public function __construct(IDatabaseService $dbService)
    {
        $this->dbService = $dbService;
    }

    public function registerUser()
    {
        // TODO: Implement registerUser() method.
    }

    public function checkUserExits()
    {
        // TODO: Implement checkUserExits() method.
    }

    public function deleteUser()
    {
        // TODO: Implement deleteUser() method.
    }

    public function updateUser()
    {
        // TODO: Implement updateUser() method.
    }
}