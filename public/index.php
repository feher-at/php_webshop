<?php


require_once __DIR__ . '/../vendor/autoload.php';



use app\Core\Application;
use app\controllers\HomeController;
use app\controllers\AuthController;
use app\controllers\ItemController;
use app\controllers\ProfileController;
use app\controllers\OrderController;

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
$app->router->get('/forgotPassword',[AuthController::class,'forgotPassword']);
$app->router->get('/register/validation',[AuthController::class,'validation']);
$app->router->post('/register',[AuthController::class, 'handleRegister']);
$app->router->post('/login',[AuthController::class, 'handleLogin']);
$app->router->post('/home',[AuthController::class, 'logout']);
$app->router->get('/forgotPassword/validation',[AuthController::class,'validation']);
$app->router->post('/forgotPassword',[AuthController::class,'handleForgotPassword']);

$app->router->post('/home',[AuthController::class, 'logout']);

/**
 * OrderController
 */

$app->router->get('/item/order',[OrderController::class,'getOrderPage']);
$app->router->post('/item/order',[OrderController::class,'createTheOrder']);

/**
 * ItemController
 */
$app->router->get('/item/itemUpload',[ItemController::class, 'getItemUploadPage']);
$app->router->post('/item/itemUpload',[ItemController::class, 'uploadItem']);

/**
 * ProfileController
 */
$app->router->get('/profile',[ProfileController::class, 'getProfilePage']);
$app->router->get('/profileUpdate',[ProfileController::class, 'getProfileUpdatePage']);
$app->router->get('/profileUpdate/validation',[AuthController::class,'validation']);
$app->router->post('/profileUpdate',[ProfileController::class, 'update']);
$app->router->get('/profileDelete',[ProfileController::class, 'delete']);
$app->router->post('/profileDelete',[ProfileController::class, 'handleDelete']);
$app->router->get('/myOrders',[ProfileController::class, 'myOrders']);



$app->run();
?>