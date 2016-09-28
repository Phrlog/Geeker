<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

?>
<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <h2 class="blog-post-title">Inline Form</h2>
                <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
                <label class="sr-only" for="exampleInputEmail2">Email address</label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <label class="sr-only" for="exampleInputPassword2">Password</label>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section><!-- /.blog-post -->

