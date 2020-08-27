<?php

namespace app\core;

class Response
{
    /**
     * @param int $code
     * This function set the response status code (e.g "status code 404")
     */
    public function setStatusCode(int $code)
    {
        http_response_code($code);
    }
}