<?php
/* @var $this yii\web\View */
/* @var array $subscriptions common\models\User */
/* @var array $subscribers common\models\User */
/* @var array  $subscriptions_id */

use frontend\assets\SubscribeAsset;

SubscribeAsset::register($this);
?>

<div class="row">
    <div class="col-sm-12 blog-main">
        <div class="row">
            <div class="col-sm-6">
                <h1>Мои подписки</h1>
                <?php foreach ($subscriptions as $user): ?>
                    <?= $this->render('/common/_user', ['subscriptions_id' => $subscriptions_id, 'user' => $user]) ?>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-6">
                <h1>Мои подписчики</h1>
                <?php foreach ($subscribers as $user): ?>
                    <?= $this->render('/common/_user', ['subscriptions_id' => $subscriptions_id, 'user' => $user]) ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
