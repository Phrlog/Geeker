<?php
/* @var $this yii\web\View */
/* @var array $users common\models\User */

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use common\models\Subscription;

?>

<div class="row">
    <div class="col-sm-12 blog-main">
        <div class="row">
            <div class="col-sm-6">
                <h1>Мои подписки</h1>
                <?php foreach ($subscriptions as $user): ?>
                    <?php
                    $me = Subscription::find()->where(['subscribe_id' => $user->id])->count();
                    $to = Subscription::find()->where(['user_id' => $user->id])->count();
                    ?>
                    <section class="blog-post">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="blog-post-content">
                                    <a href="<?= Url::to(['user/profile', 'id' => $user->id]) ?>"><h2
                                            class="blog-post-title"><?= Html::encode($user->username) ?></h2></a>
                                    <p>Подписаны: <b><?= $me ?></b></p>
                                    <p>Подписан: <b><?= $to ?></b></p>
                                    <?php if (Subscription::isRelationExist(Yii::$app->user->id, $user->id) && (Yii::$app->user->id != $user->id)): ?>
                                        <a href="<?= Url::to(['user/unsubscribe', 'id' => $user->id]); ?>">
                                            <button type="button" class="btn btn-success btn-lg subscribe_button">
                                                Подписан
                                            </button>
                                        </a>
                                    <?php elseif (Yii::$app->user->id != $user->id): ?>
                                        <a href="<?= Url::to(['user/subscribe', 'id' => $user->id]); ?>">
                                            <button type="button" class="btn btn-info btn-lg">Подписаться</button>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-6">
                <h1>Мои подписчики</h1>
                <?php foreach ($subscribers as $user): ?>
                    <?php
                    $me = Subscription::find()->where(['subscribe_id' => $user->id])->count();
                    $to = Subscription::find()->where(['user_id' => $user->id])->count();
                    ?>
                    <section class="blog-post">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="blog-post-content">
                                    <a href="<?= Url::to(['user/profile', 'id' => $user->id]) ?>"><h2
                                            class="blog-post-title"><?= Html::encode($user->username) ?></h2></a>
                                    <p>Подписаны: <b><?= $me ?></b></p>
                                    <p>Подписан: <b><?= $to ?></b></p>
                                    <?php if (Subscription::isRelationExist(Yii::$app->user->id, $user->id) && (Yii::$app->user->id != $user->id)): ?>
                                        <a href="<?= Url::to(['user/unsubscribe', 'id' => $user->id]); ?>">
                                            <button type="button" class="btn btn-success btn-lg subscribe_button">
                                                Подписан
                                            </button>
                                        </a>
                                    <?php elseif (Yii::$app->user->id != $user->id): ?>
                                        <a href="<?= Url::to(['user/subscribe', 'id' => $user->id]); ?>">
                                            <button type="button" class="btn btn-info btn-lg">Подписаться</button>
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </section>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
