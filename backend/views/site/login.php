<?php

/* @var $this \yii\web\View */
/* @var $content string */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use backend\assets\AdminAsset;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

AdminAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body id="login-page-full">
<?php $this->beginBody() ?>
<div id="login-full-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div id="login-box">
                    <div id="login-box-holder">
                        <div class="row">
                            <div class="col-xs-12">
                                <header id="login-header">
                                    <div id="login-logo">
                                        <img src="img/logo.png" alt=""/>
                                    </div>
                                </header>
                                <div id="login-box-inner">
                                    <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                                        <div class="input-group">
                                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                                        </div>
                                        <div class="input-group">
                                            <?= $form->field($model, 'password')->passwordInput() ?>
                                        </div>
                                    <div id="remember-me-wrapper">
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <?= $form->field($model, 'rememberMe', ['options' => ['id' => 'remember-me']])->checkbox(); ?>
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                            </div>
                                        </div>
                                    <?php ActiveForm::end(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>