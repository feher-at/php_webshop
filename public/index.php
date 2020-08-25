<?php
/*define('ROOT',dirname(__DIR__). DIRECTORY_SEPARATOR);
define('APP',ROOT.'app'.DIRECTORY_SEPARATOR);
define('VIEWS',ROOT.'app'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR);
define('MODELS',ROOT.'app'.DIRECTORY_SEPARATOR.'models'.DIRECTORY_SEPARATOR);
define('DATA',ROOT.'app'.DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR);
define('CORE',ROOT.'app'.DIRECTORY_SEPARATOR.'Core'.DIRECTORY_SEPARATOR);
define('CONTROLLERS',ROOT.'app'.DIRECTORY_SEPARATOR.'controllers'.DIRECTORY_SEPARATOR);
define('SERVICES',ROOT.'app'.DIRECTORY_SEPARATOR.'services'.DIRECTORY_SEPARATOR);
$modules = [ROOT,APP,CORE,CONTROLLERS,DATA];

set_include_path(get_include_path() .PATH_SEPARATOR . implode(PATH_SEPARATOR,$modules));
spl_autoload_register('spl_autoload',false);
var_dump($_SERVER['REQUEST_URI']);*/

require_once __DIR__ . '/../vendor/autoload.php';



use app\Core\Application;
use app\controllers\homeController;

$app = new Application(dirname(__DIR__));


$app->router->get('/', 'home');

$app->router->get('/contact','contact');

$app->router->post('/contact',[homeController::class, 'handleContact']);




$app->run();
?>