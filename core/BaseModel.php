<?php
namespace app\core;
abstract class BaseModel{
    public array $errors=[];
    public const RULE_REQUIRED='required';
    public const RULE_EMAIL='email';
    public const RULE_MIN='min';
    public const RULE_MAX='max';
    public const MATCH='match';
    public const UNIQUE='unique';
    abstract public function rules():array;
    public function loadData($data){
        foreach($data as $key=>$value){
            if(property_exists($this,$key)){
                $this->{$key}=$value;
            }
        }
    }
    public function addError(string $attribute,string $rule,$params=[]){
        $message=$this->errorMessage()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message=str_replace("{{$key}}",$value,$message);
        }
        $this->errors[$attribute][]=$message;
    }
    public function validate(){
        foreach($this->rules() as $attribute=>$rules){
            $value=$this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName=$rule;
                if(!is_string($ruleName)){
                    $ruleName=$rule[0];
                    
                }
                if($ruleName===self::RULE_REQUIRED && !$value){       
                    $this->addError($attribute,self::RULE_REQUIRED,$rule);
                }
                if($ruleName===self::RULE_EMAIL && !filter_var($value,FILTER_VALIDATE_EMAIL)){       
                    $this->addError($attribute,self::RULE_EMAIL);
                }
                if($ruleName===self::RULE_MIN && strlen($value)<$rule['min']){       
                    $this->addError($attribute,self::RULE_MIN,$rule);
                }
                if($ruleName===self::RULE_MAX && strlen($value)>$rule['max']){       
                    $this->addError($attribute,self::RULE_MAX,$rule);
                }
                if($ruleName===self::UNIQUE){
                    $className=$rule['class'];
                    $tableName=$className::tableName();
                    $stmt=Application::$app->db->prepare("SELECT * FROM $tableName WHERE $attribute = :attribute");
                    $stmt->bindValue(":attribute",$value);
                    $stmt->execute();
                    $record=$stmt->fetchObject();
                    if($record){
                        $this->addError($attribute,self::UNIQUE,['field'=>$value]);
                    }
                }
            }
        }
        return empty ($this->errors);
    }
    public function errorMessage(){
        return [
        self::RULE_REQUIRED=>'{placeholder} is required',
    self::RULE_EMAIL=>'Invalid Email',
    self::RULE_MIN=>'min {min}',
    self::RULE_MAX=>'max {max}',
    self::MATCH=>'match',
    self::UNIQUE=> 'Record with {field} already exists'
    
        ];
    }
    public function hasError($attribute){
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute){
        $errors=$this->errors[$attribute] ?? [];
        return $errors[0] ?? '';
    }
    
}
?>