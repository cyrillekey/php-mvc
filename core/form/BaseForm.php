<?php
namespace app\core\form;

use app\core\BaseModel;


class BaseForm{
public static function begin($action,$method){
    echo sprintf('<form action="%s" method="%s">',$action,$method);
    return new BaseForm();
}
public static function end(){
    echo '</form>';
}
public function field(BaseModel $model,$attribute,$type){
   return new BaseField($model,$attribute,$type); 
}
}
?>