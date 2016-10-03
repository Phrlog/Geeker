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
use common\models\Likes;
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
                <section class="blog-post">
                    <div class="panel panel-default">
                        <?php if ($geek->thumbnail): ?>
                            <?= Html::img(Yii::$app->UrlManager->createUrl($geek->image), ['class' => "img-responsive"]) ?>
                        <?php endif; ?>
                        <div class="panel-body">
                            <div class="blog-post-meta">
                                <a href="<?= Url::to(['user/profile', 'id' => $geek->user_id]) ?>">
                                    <span class="label label-light label-primary"><?= Html::encode($geek->getUser()->select(['username'])->one()->username) ?></span></a>
                                <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                            </div>
                            <div class="blog-post-content">
                                <a href="<?= Url::to(['geeks/view', 'id' => $geek->id]); ?>">
                                    <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                                </a>
                                <div class="like-panel" id="<?= $geek->id ?>">
                                    <span><?= Likes::find()->where(['geek_id' => $geek->id])->count() ?></span>
                                    <button type="button" data-url="<?= Url::to(['geeks/like'], true) ?>" data-id="<?= $geek->id ?>" class="btn btn-primary like">
                                        <i class="fa fa-heart <?= Likes::isRelationExist(\Yii::$app->user->id, $geek->id) ? "like" : '';?>"></i>
                                    </button>
                                </div>
                                <a class="blog-post-share pull-right" href="#">
                                    <i class="material-icons">&#xE80D;</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            <?php endforeach; ?>
        </div>
    </div>
</div>
