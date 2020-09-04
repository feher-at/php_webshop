<?php


require_once __DIR__ . '/../vendor/autoload.php';



use app\Core\Application;
use app\controllers\HomeController;
use app\controllers\AuthController;
use app\controllers\ItemController;
use app\controllers\ProfileController;

$app = new Application(dirname(__DIR__));


/**
 * HomeController
 */
$app->router->get('/', [HomeController::class,'getIndex']);
$app->router->get('/home', [HomeController::class,'getIndex']);

/**
 * AuthController
 */
$app->router->get('/register',[AuthController::class,'register']);
$app->router->get('/login',[AuthController::class, 'login']);
$app->router->get('/register/validation',[AuthController::class,'validation']);
$app->router->post('/register',[AuthController::class, 'handleRegister']);
$app->router->post('/login',[AuthController::class, 'handleLogin']);
$app->router->post('/',[AuthController::class, 'logout']);

/**
 * ItemController
 */
$app->router->get('/item/itemUpload',[ItemController::class, 'getItemUploadPage']);
$app->router->post('/item/itemUpload',[ItemController::class, 'uploadItem']);

/**
 * ProfileController
 */
$app->router->get('/profile/profile',[ProfileController::class, 'getProfilePage']);
$app->router->get('/profile/profileUpdate',[ProfileController::class, 'getProfileUpdatePage']);
$app->router->get('/profile/profileUpdate/validation',[AuthController::class,'validation']);
$app->router->post('/profile/profileUpdate',[ProfileController::class, 'update']);
$app->run();
?>