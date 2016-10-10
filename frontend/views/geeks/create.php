<?php
/* @var $this yii\web\View */
/* @var $model common\models\GeekForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
?>
<div class="panel panel-default">
    <div class="panel-body">
        <?php if (Yii::$app->session->hasFlash('success')): ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert alert-success'],
                'body' => Yii::$app->session->getFlash('success')
            ]);?>

        <?php elseif (Yii::$app->session->hasFlash('error')): ?>
            <?= Alert::widget([
                'options' => ['class' => 'alert alert-danger'],
                'body' => Yii::$app->session->getFlash('error')
            ]);?>
        <?php endif; ?>

        <?php $form = ActiveForm::begin(['enableClientValidation' => false]); ?>
        <?= $form->field($model, 'text')->textarea()->label('Введите ваш твит:') ?>
        <?= $form->field($model, 'parent_id')->textInput(['maxlength' => 255], ['class' => 'input-modal']) ?>
        <?= $form->field($model, 'imageFile', ['template' => '<i class="fa fa-file-image-o" aria-hidden="true"></i>{input} {label}'])->fileInput(['class' => 'file']) ?>
        <div class="form-group">
            <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>


