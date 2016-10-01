<?php
/* @var $geek common\models\Geeks */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="col-sm-12">
    <section class="blog-post">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="blog-post-meta">
                    <a href="<?= Url::to(['user/profile', 'id' => $geek->user_id]); ?>">
                        <span class="label label-light label-success"><?= Html::encode($geek->getUser()->select(['username'])->one()->username) ?></span></a>
                    <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                </div>
                <?php if ($geek->image): ?>
                    <?= Html::img(Yii::$app->urlManagerBackend->createUrl($geek->image), ['class' => "img-responsive"]) ?>
                <?php endif; ?>
                <div class="blog-post-content">
                        <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                    <a class="blog-post-share pull-right" href="#">
                        <i class="material-icons">&#xE80D;</i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>