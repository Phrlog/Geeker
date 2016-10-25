<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

?>
<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <h2 class="blog-post-title">Войти</h2>
                <?php $form = ActiveForm::begin(['class' => 'form-inline']); ?>
                <label class="sr-only" for="username">Имя пользователя</label>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                <label class="sr-only" for="password">Пароль</label>
                <?= $form->field($model, 'password')->passwordInput() ?>
                <?= $form->field($model, 'rememberMe')->checkbox() ?>
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                <div class="btn-group">
                    <a href="<?= Url::to('user/signup'); ?>"<button type="button" class="btn btn-primary"></button>Регистрация</a>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section><!-- /.blog-post -->

