<?php
namespace app\core\form;
use app\core\BaseModel;

class BaseField{
    public const TYPE_TEXT='text';
    public BaseModel $model;
    public string $attribute;
    public string $type;
    public function __construct(BaseModel $model,$attribute,$type)
    {
        $this->model=$model;
        $this->attribute=$attribute;
        $this->type=$type;
    }
    public function __toString()
    {
        return sprintf('<div class="mb-3">
        <label for="exampleInputEmail1" class="form-label">%s</label>
        <input type="%s" name="%s" class="form-control %s" id="exampleInputEmail1" aria-describedby="emailHelp" value="%s" >
        <div class="invalid-feedback">%s</div>
      </div>',$this->attribute,$this->type,$this->attribute,$this->model->hasError($this->attribute)?'is-invalid':'',$this->model->{$this->attribute},$this->model->getFirstError($this->attribute));
    }
    public function passwordField(){

    }
}
?>