<?php

namespace app\core;


class Router
{
    public Request $request;
    public Response $response;
    protected array $routes = [];


    public function __construct(Request $request ,Response $response){
        $this->request = $request;
        $this->response = $response;
    }
    public function get($path,$callback)
    {
        $this->routes['get'][$path] = $callback;
    }

    public function post($path,$callback)
    {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve()
    {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this ->routes[$method][$path] ?? false;
        if(!$callback){
           $this->response->setStatusCode(404);
            return $this->renderView("404_page");
        }
        if(is_string($callback)){
            return $this->renderView($callback);
        }
        if(is_array($callback)){
            Application::$app->setController(new $callback[0]());
            $callback[0] = Application::$app->getController();
        }
        return call_user_func($callback, $this->request);
    }

    public function renderView($view,$params = []){

            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view,$params);
            return str_replace('{{content}}', $viewContent,$layoutContent);

    }



    protected function layoutContent(){

        $layout = Application::$app->getController()->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/layouts/$layout.php";
        return ob_get_clean();

    }

    protected function renderOnlyView($view,$params){

       foreach($params as $key => $value) {
           $$key = $value;
       }

        ob_start();
        include_once Application::$ROOT_DIR."/app/views/$view.php";
        return ob_get_clean();

    }
}
