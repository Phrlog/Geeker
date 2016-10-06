<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */

use frontend\assets\LikesAsset;
use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
LikesAsset::register($this);
use common\models\Likes;

?>
<?php foreach ($geeks as $geek): ?>
    <div class="col-sm-8 blog-main">
        <div class="row">
            <div class="col-sm-6">
                <section class="blog-post">
                    <div class="panel panel-default">
                        <?php if ($geek->thumbnail): ?>
                            <?= Html::img(Yii::$app->UrlManager->createUrl($geek->image), ['class' => "img-responsive"]) ?>
                        <?php endif; ?>
                        <div class="panel-body">
                            <div class="blog-post-meta">
                                <a href="<?= Url::to(['user/profile', 'id' => $geek->user_id]) ?>">
                                    <span class="label label-light label-primary"><?= Html::encode($geek->username) ?></span></a>
                                <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                            </div>
                            <div class="blog-post-content">
                                <a href="<?= Url::to(['geeks/view', 'id' => $geek->id]); ?>">
                                    <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                                </a>
                                <div class="like-panel" id="<?= $geek->id ?>">
                                    <span><?= $geek->count ?></span>
                                    <button type="button" data-url="<?= Url::to(['geeks/like'], true) ?>" data-id="<?= $geek->id ?>" class="btn btn-primary like">
                                        <i class="fa fa-heart <?= in_array($geek->id, $likes) ? "like" : '';?>"></i>
                                    </button>
                                </div>
                                <a class="blog-post-share pull-right" href="#">
                                    <i class="material-icons">&#xE80D;</i>
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
<?php endforeach; ?>