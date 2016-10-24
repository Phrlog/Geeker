<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */
/* @var $user common\models\User */
/* @var array  $likes */
/* @var $me   integer */
/* @var $to   integer */

use yii\helpers\Html;
use yii\helpers\Url;
use frontend\assets\LikesAsset;

LikesAsset::register($this);
?>
<div class="col-sm-4">
    <div class="panel panel-default floating">
        <header class="main-box-header clearfix">
            <h2><?= Html::encode($user->username) ?></h2>
        </header>
        <?php if ($user->isUserAdmin($user->username)): ?>
            <div class="profile-label">
                <span class="label label-danger">Admin</span>
            </div>
        <?php endif; ?>
        <div class="panel-body">
            <?php if ($user->avatar): ?>
                <div class=" avatar">
                    <?= Html::img(Yii::$app->UrlManager->createUrl($user->thumbnail), ['class' => "img-responsive"]) ?>
                </div>
            <?php endif; ?>
            <p>Подписаны: <a href="<?= Url::to(['user/subscribers', 'id' =>  $user->id]) ?>"><b><?= $me ?></b></p></a>
            <p>Подписан: <a href="<?= Url::to(['user/subscriptions', 'id' =>  $user->id]) ?>"><b><?= $to ?></b></p></a>
            <a href="<?= Url::to(['site/logout']) ?>">
                <button type="button" class="btn btn-warning btn-raised">Выйти</button
            </a>
        </div>
    </div>
</div>
<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($geeks as $geek): ?>
                <?= $this->render('/common/_geek', ['likes' => $likes, 'geek' => $geek, 'username' => $user->username]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>

