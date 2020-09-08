<?php

namespace app\services;
use app\services\Validations;
use app\models\User;



class UserService implements IUserService
{
    private $database;
    private $connection;

    public function __construct()
    {
        $this->database = DatabaseService::getInstance();
        $this->connection = $this->database->getConnection();
    }

    /**
     * Register the user with the given parameters,and return with the registered user's id
     *
     * @param array $params
     * The parameters with the user register
     * @return array
     * Return with the registered user id
     *
     */
    public function registerUser(array $params)
    {
        $this->database->reConnect();

        $query = "INSERT INTO users (user_email,user_taxnum,user_password,confirmed,hashed_email_for_validation)
                    VALUES($1,$2,$3,$4,$5)";
        $latestUserHashedEmailQuery = "SELECT users.hashed_email_for_validation FROM users ORDER BY users.user_id DESC LIMIT 1 ";
        $hashedEmail =  md5($params['user_email']);

        pg_query_params($this->connection,$query,array($params['user_email'],$params['user_taxnum'],$params['user_password'],0,
                                                        md5($params['user_email'])));
        $result = pg_query($this->connection,$latestUserHashedEmailQuery);

        return pg_fetch_assoc($result);

    }

    public function checkUserExists($email)
    {
        $result=pg_prepare($this->connection,"check_user","SELECT * FROM users WHERE user_email = $1 ");
        $result = pg_execute($this->connection,"check_user",$email);
        if(!$result){
            return null;
        }
        else{
            return pg_fetch_assoc($result);
        }

    }

    public function logInUser(array $credentials){
        $result = $this->checkUserExists(array($credentials['user_email']));
        if($result == null){
            return false;
        }
        else if (password_verify($credentials['user_password'],$result["user_password"]) && $result["confirmed"]=='t'){
            return $result['user_id'];
        }
        else {
            return false;
        }

    }

    public function deleteUser()
    {
        // TODO: Implement deleteUser() method.
    }

    /**
     * Update the confirm column in the database on the given user id.
     *
     * @param $userID
     *
     */
    public function updateUserConfirmColumn($userID)
    {
        $this->database->reConnect();
        $query = "UPDATE users SET confirmed = true WHERE users.user_id = $1";

        pg_query_params($this->connection,$query,array($userID));
    }

    /**
     * Validate the data what which the user want to registering.
     * @param array $validationParams
     * Validation params what the user sent with the request.
     * @return array All the errors what occurs via miss type or empty fields
     *
     */
    public function registrationValidation(array $validationParams)
    {
        $errors = array();

        $errors['email'] = Validations::emailValidation($validationParams['email']);

        $errors['taxNumber'] = Validations::registerTaxNumberValidation($validationParams['taxNumber']);

        $errors['password'] = Validations::passwordValidation($validationParams['password']);

        $errors['confirmPassword'] = Validations::confirmPasswordValidation($validationParams['confirmPassword'],
                                                                            $validationParams['password']);
        foreach($errors as $key => $value)
        {
            if(!is_null($value))
            {

                return $errors;
            }
        }
        return $errors = array();
    }

    /**
     * Get the user via it's hashed email address.
     *
     * @param $hashedEmail
     *  This need to be an existing hashed email value
     * @return User
     * Return with the User to which the email belongs
     *
     */
    public function getUserByHashedEmail($hashedEmail): User{

        $allUser = pg_fetch_all(pg_query($this->connection, "Select * From users"));

        foreach ($allUser as $oneUser => $userValues)
        {
           if($hashedEmail === $userValues['hashed_email_for_validation']){

               return new User($userValues);
           }

        }

    }
    public function getUserById($userId): User{
        $user=pg_prepare($this->connection,"get_user","SELECT * FROM users WHERE user_id = $1 ");
        $user = pg_execute($this->connection,"get_user",array($userId));
        return new User(pg_fetch_assoc($user));

        }
    public function updateUser($params){
        pg_update($this->connection,"users",$params,array('user_id'=>$_COOKIE['type']));
    }
}