<?php
namespace app\core;

use Exception;

abstract class DbModel extends BaseModel{
    abstract public function tableName(): string;
    abstract public function attributes(): array;
    public function save(){
        try{
        $tableName=$this->tableName();
        $attributes=$this->attributes();
        $params=array_map(fn($n)=>":$n",$attributes);
        $stmt = SELF::prepare("INSERT INTO $tableName (".implode(",",$attributes).") VALUES (".implode(",",$params).")");
       foreach($attributes as $attribute){
           $stmt->bindValue(":$attribute",$this->{$attribute});
       }
       $stmt->execute();
    return true;
    }catch(Exception $e){
        return false;
    }

    }
    static public function prepare($sql){
        return Application::$app->db->pdo->prepare($sql);
    }
}
?>