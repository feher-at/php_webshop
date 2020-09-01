<?php


require_once __DIR__ . '/../vendor/autoload.php';



use app\Core\Application;
use app\controllers\homeController;
use app\controllers\authController;

$app = new Application(dirname(__DIR__));



$app->router->get('/', [HomeController::class,'getIndex']);
$app->router->get('/home', [HomeController::class,'getIndex']);

//authentication
$app->router->get('/register',[AuthController::class,'register']);
$app->router->post('/register',[AuthController::class, 'handleRegister']);
$app->router->get('/login',[AuthController::class, 'login']);
$app->router->post('/login',[AuthController::class, 'handleLogin']);
$app->router->post('/layout',[AuthController::class, 'logout']);





$app->run();
?>