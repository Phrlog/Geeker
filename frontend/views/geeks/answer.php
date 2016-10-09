<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * @var yii\web\View $this
 * @var common\models\Geeks $model
 * @var yii\widgets\ActiveForm $form
 */
?>
<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
<div id="success"> </div> <!-- For success message -->

<div class="gb-user-form">

    <?php $form = ActiveForm::begin(['options' => ['class' => 'signup-form',
        'id' => 'answer-to-tweet', 'data-url'=> Url::to(['geeks/answer'], true)], 'enableClientValidation' => false]); ?>

    <?= $form->field($model, 'parent_id')->textInput(['maxlength' => 255], ['class' => 'input-modal']) ?>

    <?= $form->field($model, 'text')->textInput(['maxlength' => 255], ['class' => 'input-modal']) ?>

    <?= $form->field($model, 'imageFile', ['template' => '<i class="fa fa-file-image-o" aria-hidden="true"></i>{input} {label}'])->fileInput(['class' => 'file']) ?>

    <div class="form-group text-right">
        <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>