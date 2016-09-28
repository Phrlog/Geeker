<?php
/* @var $geek common\models\Geeks */

use yii\helpers\Html;
?>

<div class="col-sm-12">
    <section class="blog-post">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="blog-post-meta">
                    <span class="label label-light label-success"><?= $geek->getAuthor()->username ?></span>
                    <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                </div>

                <?php if ($geek->image): ?>
                    <?= Html::img(Yii::$app->urlManagerBackend->createUrl($geek->image), ['class' => "img-responsive"]) ?>
                <?php endif; ?>

                <div class="blog-post-content">
                    <a href="post-image.html">
                        <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                    </a>
                    <a class="blog-post-share pull-right" href="#">
                        <i class="material-icons">&#xE80D;</i>
                    </a>
                </div>
            </div>
        </div>
    </section>
</div>