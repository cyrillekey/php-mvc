<?php
namespace app\core\form;

use PDO;

class BaseForm{
public static function begin($action,$method){
    return sprintf('<form action="%s" method="%s">',$action,$method);
}
public static function end(){
    return '</form>';
}
}
?>