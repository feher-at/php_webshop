<?php


namespace app\core;


class Controller
{
    public string $layout = 'layout';

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }


    public function render($view,$params = [])
    {
        return Application::$app->router->renderView($view,$params);
    }
}