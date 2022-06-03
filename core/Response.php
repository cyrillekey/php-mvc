<?php
namespace app\core;
class Response{
public function getStatusCode($code){
    http_response_code($code);
}
public function redirect(string $var = null)
{
    header('Location: '.$var);
}
}
?>