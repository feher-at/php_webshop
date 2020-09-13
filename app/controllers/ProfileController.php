<?php
namespace app\controllers;


use app\Core\Controller;
use app\Core\Request;
use app\models\Item;
use app\services\Interfaces\IEmailService;
use app\services\Interfaces\IOrderService;
use app\services\Interfaces\IProfileService;
use app\services\OrderService;
use app\services\ProfileService;
use app\services\UserService;
use app\services\ItemService;
use app\services\Interfaces\IUserService;
use app\services\EmailService;
use PHPMailer\PHPMailer\Exception;
use stdClass;
use app\services\Paginator;

class ProfileController extends Controller{
    private IProfileService $profileService;
    private IUserService $userService;
    private IEmailService $emailService;
    private Paginator $paginator;
    private IOrderService $orderService;
    private ItemService $itemService;

    public function __construct(){
        $this->paginator = new Paginator();
        $this->profileService = new ProfileService();
        $this->userService = new userService();
        $this->emailService = new EmailService();
        $this->orderService = new OrderService();
        $this->itemService = new ItemService();
    }
    /**
     * If the user is logged in it returns their profile page
     * else it redirects to the login view.
    */
    public function getProfilePage(){
        if( isset($_COOKIE["type"])){
            $this->setLayout('layout');
            return $this->render('profile/profile',$this->profileService->getUser());
        }
        $this->redirect('/login');
    }
    /**
     * If the user is logged in it returns their profile update page
     * else it redirects to the login view.
     */
    public function getProfileUpdatePage(){
        if( isset($_COOKIE["type"])) {
            $this->setLayout('layout');
            return $this->render('profile/profileUpdate', $this->profileService->getUser());
        }
        $this->redirect('/login');
    }
    /**
     * Returns the currently logged in user.
    */
    public function getCurrentUser(){
        return $this->profileService->getUser();
    }
    /**
     * Sends out an email to the user to confirm that the user's profile update was successful.
    */
    public function sendUpdateEmail(){
        $address = "phptestuser01@gmail.com";
        $subject ="Successful update";
        $message = "You have successfully updated your profile informations!";
        try {
            $this->emailService->EmailSending($subject,$message,$address);
        } catch (Exception $e) {
            echo $e->errorMessage();
        }
    }

    /**
     * Gets the user's typed in credentials from the update page as an associative array, removes every
     * empty value with the corresponding key.
     * Also removes 'confirmPassword' key .
     * Should only be used after the user's password has been confirmed .
     * @param $userData
     * Credentials typed in by the user at the update view, stored as an assoc array.
     * @return array
     * returns the associative array with the necessary user data.
     */
    public function removeEmptyValues($userData){
        foreach($userData as $key => $value){
            if($value == "" || $key == 'confirmPassword'){
                unset($userData[$key]);}
        }
        return $userData;
    }

    /**
     * Validates where it's needed, in case of invalid data it returns to the update view with errors.
     * If the validation was successful it updates the user's data in the database and sends a confirmation email to
     * the user and renders the profile view.
     * @param Request $request
     * The user's new data .
     * @return string|string[]
     */
    public function update(Request $request)
    {
        $body = $request->getBody();
        $errors = $this->profileService->updateValidation($body);
        if($errors != []){
            return $this->render('profile/profileUpdate',$errors);
        }
        $this->sendUpdateEmail();
        $body = $this->removeEmptyValues($body);
        if(array_key_exists('user_password',$body)){
            password_hash($body['user_password'],PASSWORD_BCRYPT);
        }
        $this->profileService->updateProfile($body);
        return $this->render('profile/profile',$this->profileService->getUser());
    }

    public function delete(){
        if( isset($_COOKIE["type"])){
            $this->setLayout('layout');
            return $this->render('profile/profileDelete');
        }
        $this->redirect('/login');
    }

    public function handleDelete(Request $request){
        if( isset($_COOKIE["type"])){
            $auth = new AuthController();
            $this->profileService->deleteProfile($_COOKIE["type"]);
            $auth->cookieDelete();
            $this->setLayout('layout');
            $this->redirect('/home');
        }
        $this->redirect('/login');
    }
    public function myOrders(Request $request){
        if( isset($_COOKIE["type"])){
        $body = $request->getBody();
        $userId = $_COOKIE['type'];
        if(!isset($body["page"])){
            $currentPage = 1;
        }
        else{
        $currentPage = $body["page"];
        }
            $amountOfData = count($this->orderService->getAllOrdersOfUser($userId));
            if($amountOfData!=0) {
                $numberOfPages = $this->paginator->countPages($amountOfData);

                if ($currentPage > $numberOfPages || $currentPage <= 0 || $currentPage == null) {
                    return $this->render('404_page');
                }
                $orderArray = $this->paginator->getOrders($currentPage, $userId);
                $object = new stdClass();
                $object->orderArray = $orderArray;
                $object->pages = $numberOfPages;
                $object->currentPage = $currentPage;
                $this->setLayout('layout');
                return $this->render('profile/myOrders', $object);
            }
            else{
                $errorObject = new stdClass();
                $errorObject->dataType = 'orders';
                $this->setLayout('layout');
                return $this->render('profile/noDataPage',$errorObject);
            }
        }
        $this->redirect('/login');
    }
    public function getOrder(Request $request){
        $body = $request->getBody();
        $orderId = $body["order_id"];
        if($this->orderService->checkOrderOwner($_COOKIE['type'],$orderId)) {
            $order = $this->orderService->getOrderById($orderId);
            $this->setLayout('layout');
            return $this->render('profile/order', $order);
        }
        return $this->render('404_page');

    }
    public function myItems(Request $request){
        if( isset($_COOKIE["type"])) {
            $body = $request->getBody();
            $userId = $_COOKIE["type"];
            if(!isset($body["page"])){
                $currentPage = 1;
            }
            else{
                $currentPage = $body["page"];
            }
            $amountOfData = count($this->itemService->getUserItemId($userId));
            if($amountOfData!=0){
            $numberOfPages = $this->paginator->countPages($amountOfData);
            if($currentPage>$numberOfPages || $currentPage<=0 || $currentPage ==null ){
                return $this->render('404_page');
            }
            $itemArray = $this->paginator->getItemsOfUser($currentPage,$userId);
            $object = new stdClass();
            $object->itemArray = $itemArray;
            $object->pages = $numberOfPages;
            $object->currentPage = $currentPage;
            $object->imageSource = "/Pictures/ItemPictures/";

            $this->setLayout('layout');
            return $this->render('profile/myItems',$object);
        }else{
                $errorObject = new stdClass();
                $errorObject->dataType = 'items';
            $this->setLayout('layout');
            return $this->render('profile/noDataPage',$errorObject);
        }
        }
        else {
            return $this->redirect('/login');
        }
    }



}