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
        $registerModel=new RegisterModel();
        return $this->render('contact',['model'=>$registerModel]);
    }
    
    public function handleContact(Request $request){
        $registerModel=new RegisterModel();
        $registerModel->loadData($request->getBody());
        
        if($registerModel->validate() && $registerModel->save()){
            Application::$app->response->redirect("/contact");
            exit;
        }
        
        return $this->render('contact',['model'=>$registerModel]);
    }
}
?>