<?php
namespace app\Core;

class Request
{
    /**
     *the getPath() function return with the clear url path without the query parameters
     */
    public function getPath()
    {
        $path = $_SERVER['REQUEST_URI'] ?? '/';
        $position = strpos($path, '?');

        if(!$position){
            return $path;
        }
        return substr($path,0,$position);
    }

    public function getMethod(){

        return strtolower($_SERVER['REQUEST_METHOD']);

    }

    /**
     * the getBody() function determine the request method,and it return with a associative array
     * which contains the request method parameters as a key/value pair
     * @return array
     */
    public function getBody(){

        $body = [];
        if($this->getMethod() === 'get'){
            foreach ($_GET as $key => $value){
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }

        if($this->getMethod() === 'post'){
            foreach ($_POST as $key => $value){
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }

        }
        return $body;

    }

}