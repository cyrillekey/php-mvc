<?php
namespace app\models;

use app\core\BaseModel;

class RegisterModel extends BaseModel{
    public string $firstname="";
    public string $email='';
    public string $password='';
    public function rules(): array
    {
        return [
            'firstname'=>[[SELF::RULE_REQUIRED,'placeholder'=>'firstname']],
            'email'=>[SELF::RULE_REQUIRED,SELF::RULE_EMAIL],
            'password'=>[[SELF::RULE_REQUIRED,'placeholder'=>'password']]
        ];
    }
    
}
?>