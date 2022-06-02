<?php
namespace app\core;
class BaseController{
    public string $layout;
    public function render($path,$data=[]){
        return Application::$app->router->renderView($path,$data);
    }
    public function setLayout($layout){

    }
    public function renderString($content){
        return Application::$app->router->renderContent($content);
    }
}

?>