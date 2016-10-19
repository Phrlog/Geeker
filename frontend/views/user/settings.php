<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;

/* @var $this yii\web\View */
/* @var $model common\models\SettingsForm */
/* @var $form ActiveForm */
?>
<div class="panel panel-default">
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
    <div class="panel-body">
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'username')->textInput(['maxlength' => 255], ['class' => 'input-modal']) ?>
            <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'avatar', ['template' => '<i class="fa fa-file-image-o" aria-hidden="true"></i>{input} {label}'])->fileInput(['class' => 'file']) ?>
        <?= $form->field($model, 'filter')->dropDownList($items, ['prompt' => 'Выберите фильтр']) ?>
        <?php if ($user->avatar): ?>
            <?= Html::img(Yii::$app->UrlManager->createUrl($user->thumbnail), ['class' => "img-responsive"]) ?>
        <?php endif; ?>
            <div class="form-group">
                <?= Html::submitButton('Изменить', ['class' => 'btn btn-primary']) ?>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
