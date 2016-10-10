<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */
/* @var $user common\models\User */
/* @var $me   integer */
/* @var $to   integer */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Subscription;
use Yii;
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
            <p>Подписаны: <a href="<?= Url::to(['user/subscribers', 'id' =>  $user->id]) ?>"><b><?= $me ?></b></p></a>
            <p>Подписан: <a href="<?= Url::to(['user/subscriptions', 'id' =>  $user->id]) ?>"><b><?= $to ?></b></p></a>
            <?php if (Subscription::isRelationExist(Yii::$app->user->id, $user->id)): ?>
                <a href="<?= Url::to(['user/unsubscribe', 'id' => $user->id]); ?>">
                    <button type="button" class="btn btn-success btn-lg subscribe_button">Подписаны</button>
                </a>
            <?php else: ?>
                <a href="<?= Url::to(['user/subscribe', 'id' => $user->id]); ?>">
                    <button type="button" class="btn btn-info btn-lg">Подписаться</button>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-12">
            <?php foreach ($geeks as $geek): ?>
                <?php include '_geek.php'?>
            <?php endforeach; ?>
        </div>
    </div>
</div>
