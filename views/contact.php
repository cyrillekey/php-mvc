
<div class="container">
<?php
$form=\app\core\form\BaseForm::begin("","POST");
echo $form->field($model,'firstname','text');
echo $form->field($model,'email','email');
echo $form->field($model,'password','password');

?>
<button type="submit" class="btn btn-primary">Submit</button>
  <?=\app\core\form\BaseForm::end()?>
</div>