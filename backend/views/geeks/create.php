<?php
/* @var $this yii\web\View */
/* @var $model common\models\GeekForm */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Alert;
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'text')->label('Введите ваш твит:') ?>

<?= $form->field($model, 'imageFile')->fileInput() ?>

<div class="form-group">
    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>

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

