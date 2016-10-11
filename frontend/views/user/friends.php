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
                    <?php include '_user.php' ?>
                <?php endforeach; ?>
            </div>
            <div class="col-sm-6">
                <h1>Мои подписчики</h1>
                <?php foreach ($subscribers as $user): ?>
                    <?php include '_user.php' ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
