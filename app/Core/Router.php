<?php

namespace app\Core;


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

    /**
     * @return mixed|string|string[]
     * The resolve() function get the path and the request method,and it's set the controller based on the
     * $callback,if the $callback contains the request method and the path,then the 0. parameter get the correspondent
     * controller via the Application class getController method and return the call_user_func(),else just call the renderView() function,
     * or if there is no correspond path in the routing it returns with the 404_page and with a 404 status code.
     */
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

    /**
     * @param $view
     * @param array $params
     * @return string|string[]
     *
     * Render the layout page with the view page
     */
    public function renderView($view,$params = []){

            $layoutContent = $this->layoutContent();
            $viewContent = $this->renderOnlyView($view,$params);
            return str_replace('{{content}}', $viewContent,$layoutContent);

    }


    /**
     * @return false|string
     * Render only the layout page
     */
    protected function layoutContent(){

        $layout = Application::$app->getController()->layout;
        ob_start();
        include_once Application::$ROOT_DIR."/app/views/layouts/$layout.php";
        return ob_get_clean();

    }

    /**
     * @param $view
     * @param $params
     * @return false|string
     * Render only the given view page
     */
    protected function renderOnlyView($view,$params){

       foreach($params as $key => $value) {
           $$key = $value;
       }


        ob_start();
        include_once Application::$ROOT_DIR."/app/views/$view.php";
        return ob_get_clean();

    }
}
