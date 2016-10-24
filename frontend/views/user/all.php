<?php
/* @var $this yii\web\View */
/* @var array $users common\models\User */
/* @var array  $subscriptions_id */

use yii\helpers\Html;
use frontend\assets\SubscribeAsset;

SubscribeAsset::register($this);

$this->title = Html::encode($title);
?>

<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-12">
            <h2><?= $this->title ?></h2>
            <?php foreach ($users as $user): ?>
                <?= $this->render('/common/_user', ['subscriptions_id' => $subscriptions_id, 'user' => $user]) ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>