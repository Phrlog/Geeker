<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\AutoComplete;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'username')->widget(
    AutoComplete::className(), [
    'clientOptions' => [
        'source' => $users,
    ],
    'options'=>[
        'class'=>'form-control'
    ]
]);
?>
<?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
<?php ActiveForm::end(); ?>
