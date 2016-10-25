<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
?>

<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <h2 class="blog-post-title"><?= $this->title ?></h2>
                <?php $form = ActiveForm::begin(['class' => 'form-horizontal style-form']); ?>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <?= $form->field($model, 'email') ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10">
                            <?= $form->field($model, 'password')->passwordInput() ?>
                        </div>
                    </div>
                     <div class="form-group">
                         <div class="col-sm-10">
                         <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
                         </div>
                     </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>