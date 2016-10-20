<?php
use yii\helpers\Html;
use yii\helpers\Url;
?>

<section class="blog-post">
    <div class="panel panel-default">
        <div class="panel-body">
            <div class="blog-post-content">
                <a href="<?= Url::to(['user/profile', 'id' => $user->id]) ?>"><h2
                        class="blog-post-title"><?= Html::encode($user->username) ?></h2></a>
                <?php if ($user->avatar): ?>
                    <div class=" avatar">
                        <?= Html::img(Yii::$app->UrlManager->createUrl($user->thumbnail), ['class' => "img-responsive"]) ?>
                    </div>
                <?php endif; ?>
                <p>Подписаны: <a href="<?= Url::to(['user/subscribers', 'id' =>  $user->id]) ?>"><b><?= $user->subscribers ?></b></p></a>
                <p>Подписан: <a href="<?= Url::to(['user/subscriptions', 'id' =>  $user->id]) ?>"><b><?= $user->subscriptions ?></b></p></a>
                <div class="subscribe-panel" data-url="<?= Url::to(['user/subscribe'], true) ?>" data-id="<?= $user->id ?>">
                    <?php if (in_array($user->id, $subscriptions_id)): ?>
                        <button type="button" class="btn btn-success btn-lg unsubscribe_button subscribe">
                            Подписаны
                        </button>
                    <?php elseif ( Yii::$app->user->id != $user->id): ?>
                        <button type="button" class="btn btn-info btn-lg subscribe">
                            Подписаться
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>