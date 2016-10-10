<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\jui\AutoComplete;

?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->widget(
            AutoComplete::className(), [
            'clientOptions' => [
                'source' => $users,
            ],
            'options' => [
                'class' => 'form-control'
            ]
        ]);
        ?>
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        <?php ActiveForm::end(); ?>
    </div>
</div>