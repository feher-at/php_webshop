<?php
namespace app\services;
use app\Core\Request;
use app\models\User;
use app\services\UserService;

class ProfileService implements IProfileService{

    private IUserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
    /**
     * Returns the currently logged in user.
    */
    public function getUser() : User{
        return $this->userService->getUserById($_COOKIE["type"]);

    }

    /**
     * Gives the user's new credentials to the database update function.
     * @param $params
     */
    public function updateProfile($params){
        $this->userService->updateUser($params);
    }

    /**
     * Validates the user's new data .
     * @param array $validationParams
     * The user's data coming from profileUpdate .
     * @return array
     * Returns the errors in an array. Returns empty array if there are no errors.
     */
    public function updateValidation(array $validationParams){
        $errors = [];
        if(array_key_exists('user_taxnum',$validationParams)) {
            $errors['taxNumber'] = Validations::updateTaxNumberValidation($validationParams['user_taxnum']);
        }
        if(!empty($validationParams['user_password'])){
        $errors['confirmPassword'] = Validations::confirmPasswordValidation($validationParams['confirmPassword'],
            $validationParams['user_password']);}
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = [];
    }
    public function deleteProfile($userId){
        $itemService = new ItemService();
        $itemService->deleteItemShipping($userId);
        $itemService->deleteItemsOfUser($userId);
        $this->userService->deleteUser($userId);
    }
}