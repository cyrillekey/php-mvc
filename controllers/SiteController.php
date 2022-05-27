<?php
namespace app\controllers;

use app\core\Application;
use app\core\BaseController;
use app\core\Request;
use app\models\RegisterModel;

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
        $registerModel=new RegisterModel();
        $registerModel->loadData($request->getBody());
        
        $registerModel->validate();
        
        return $this->render('contact',['model'=>$registerModel]);
    }
}
?>