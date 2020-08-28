<?php


namespace app\core;


class Controller
{
    public string $layout = 'layout';

    /** it set the actual layout view what we want to use
     * @param $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }


    public function render($view,$params = [])
    {
        return Application::$app->router->renderView($view,$params);
    }
    function redirect($url, $statusCode = 303)
    {
        header('Location: http://localhost:8000'. $url  , true, $statusCode);
        die();
    }
}