<?php


require_once __DIR__ . '/../vendor/autoload.php';



use app\Core\Application;
use app\controllers\homeController;
use app\controllers\authController;

$app = new Application(dirname(__DIR__));



$app->router->get('/', [homeController::class,'getIndex']);
$app->router->get('/home', [homeController::class,'getIndex']);

//authentication
$app->router->get('/register',[authController::class,'register']);
$app->router->post('/register',[authController::class, 'handleRegister']);
$app->router->get('/login',[authController::class, 'login']);
$app->router->post('/login',[authController::class, 'login']);





$app->run();
?>