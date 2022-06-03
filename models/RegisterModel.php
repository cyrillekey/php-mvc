<?php
namespace app\models;
use app\core\DbModel;

class RegisterModel extends DbModel{
    public string $firstname="";
    public string $email='';
    public string $password='';
    public function rules(): array
    {
        return [
            'firstname'=>[[SELF::RULE_REQUIRED,'placeholder'=>'firstname']],
            'email'=>[
                [SELF::RULE_REQUIRED,'placeholder'=>'email'],
                SELF::RULE_EMAIL,
                [SELF::UNIQUE,'class'=>self::class]
            ],
            'password'=>[[SELF::RULE_REQUIRED,'placeholder'=>'password']]
        ];
    }
    public function tableName():string{
                return 'user_table';
    }
    public function save(){
        $this->password=password_hash($this->password,PASSWORD_DEFAULT);
        return parent::save();
    }
    public function attributes(): array
    {
        return ['firstname','email','password'];
    }
    
}
?>