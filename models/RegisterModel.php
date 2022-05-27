<?php
namespace app\models;

use app\core\BaseModel;

class RegisterModel extends BaseModel{
    public string $email;
    public string $password;
    public function rules(): array
    {
        return [
            'email'=>[SELF::RULE_REQUIRED,SELF::RULE_EMAIL],
            'password'=>[SELF::RULE_REQUIRED,[SELF::RULE_MIN,'min'=>8]]
        ];
    }
    
}
?>