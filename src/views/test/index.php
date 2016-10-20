<?php
use yii\bootstrap\ActiveForm;

$form = ActiveForm::begin();
echo $form->field($model, 'files')->widget('\chabberwock\files\FileUpload');
echo '<button type="submit">submit</button>';
ActiveForm::end();
?>


