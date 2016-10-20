<?php
/* @var $this yii\web\View */
/* @var array $users common\models\User */

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
use common\models\Subscription;
use frontend\assets\SubscribeAsset;

SubscribeAsset::register($this);

$this->title = Html::encode($title);
?>

<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-12">
            <h2><?= $this->title ?></h2>
            <?php foreach ($users as $user): ?>
                <?php include '_user.php' ?>
            <?php endforeach; ?>
        </div>
    </div>
</div>