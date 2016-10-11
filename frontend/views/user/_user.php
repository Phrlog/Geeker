<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Subscription;
?>

<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <a href="<?= Url::to(['user/profile', 'id' => $user->id]) ?>"><h2
                        class="blog-post-title"><?= Html::encode($user->username) ?></h2></a>
                <p>Подписаны: <a href="<?= Url::to(['user/subscribers', 'id' =>  $user->id]) ?>"><b><?= $user->subscribers ?></b></p></a>
                <p>Подписан: <a href="<?= Url::to(['user/subscriptions', 'id' =>  $user->id]) ?>"><b><?= $user->subscriptions ?></b></p></a>
                <?php if (Subscription::isRelationExist(Yii::$app->user->id, $user->id) && (Yii::$app->user->id != $user->id)): ?>
                    <a href="<?= Url::to(['user/unsubscribe', 'id' => $user->id]); ?>">
                        <button type="button" class="btn btn-success btn-lg subscribe_button">
                            Подписаны
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