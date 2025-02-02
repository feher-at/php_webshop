<?php

namespace app\Core;



class Application
{
    public static string  $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public static Application $app;
    private Controller $controller;

    /**
     * @return Controller
     */
    public function getController(): Controller
    {
        return $this->controller;
    }

    /**
     * @param Controller $controller
     */
    public function setController(Controller $controller): void
    {
        $this->controller = $controller;
    }


    public function __construct($rootPath){

        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request,$this->response);
        $this->controller = new Controller();


    }


    public function run(){
        echo $this->router->resolve();
    }



}