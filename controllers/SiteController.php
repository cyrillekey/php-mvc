<?php
namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;

class SiteController extends BaseController{
    public function home(){
        $params=[
            'name'=>'Jogn Doe'
        ];
        return $this->render('home',$params);
    }
    public function contact(){
        return $this->render('contact');
    }
    public function handleContact(Request $request){
        $body=$request->getBody();
        var_dump($body);
        return 'Handling dorm';
    }
}
?>