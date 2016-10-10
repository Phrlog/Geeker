<?php
/* @var $geek common\models\Geeks */

use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Likes;
use frontend\assets\LikesAsset;
use frontend\assets\AnswerAsset;

LikesAsset::register($this);
AnswerAsset::register($this);

?>

<div class="col-sm-12">
    <section class="blog-post">
        <div class="panel panel-default">
            <?php if ($geek->thumbnail): ?>
                <?= Html::img(Yii::$app->UrlManager->createUrl($geek->image), ['class' => "img-responsive"]) ?>
            <?php endif; ?>
            <div class="panel-body">
                <div class="blog-post-meta">
                    <?php if ($geek->parent_id): ?>
                        <a href="<?= Url::to(['geeks/view', 'id' => $geek->parent_id]) ?>">
                            <i class="fa fa-chevron-left" aria-hidden="true"></i>
                        </a>
                    <?php endif; ?>
                    <a href="<?= Url::to(['user/profile', 'id' => $geek->user_id]) ?>">
                        <span class="label label-light label-primary">
                            <?= Html::encode($geek->getUser()->select(['username'])->one()->username) ?>
                        </span></a>
                    <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                </div>
                <div class="blog-post-content">
                    <a href="<?= Url::to(['geeks/view', 'id' => $geek->id]); ?>">
                        <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                    </a>
                    <div class="like-panel" id="<?= $geek->id ?>">
                        <span><?= $geek->count ?></span>
                        <button type="button" data-url="<?= Url::to(['geeks/like'], true) ?>"
                                data-id="<?= $geek->id ?>" class="btn btn-primary like">
                            <i class="fa fa-heart <?= Likes::isRelationExist(\Yii::$app->user->id, $geek->id) ? "like" : ''; ?>"></i>
                        </button>

                        <button type="button" data-url="<?= Url::to(['geeks/answer'], true) ?>" data-id="<?= $geek->id ?>" class="btn btn-primary answer">
                            <i class="fa fa-reply""></i>
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
<?php if ($answers != null): ?>
    <?php foreach ($answers as $answer): ?>
        <div class="col-sm-8">
            <section class="blog-post">
                <div class="panel panel-default">
                    <?php if ($answer->thumbnail): ?>
                        <?= Html::img(Yii::$app->UrlManager->createUrl($answer->image), ['class' => "img-responsive"]) ?>
                    <?php endif; ?>
                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <?php if ($answer->parent_id): ?>
                                <a href="<?= Url::to(['geeks/view', 'id' => $answer->parent_id]) ?>">
                                    <i class="fa fa-chevron-left" aria-hidden="true"></i>
                                </a>
                            <?php endif; ?>
                            <a href="<?= Url::to(['user/profile', 'id' => $answer->user_id]) ?>">
                                <span class="label label-light label-primary">
                                    <?= Html::encode($answer->getUser()->select(['username'])->one()->username) ?>
                                </span></a>
                            <p class="blog-post-date pull-right"><?= $answer->updated_at ?></p>
                        </div>
                        <div class="blog-post-content">
                            <a href="<?= Url::to(['geeks/view', 'id' => $answer->id]); ?>">
                                <h2 class="blog-post-title"><?= Html::encode($answer->text) ?></h2>
                            </a>
                            <div class="like-panel" id="<?= $answer->id ?>">
                                <span><?= $answer->count ?></span>
                                <button type="button" data-url="<?= Url::to(['geeks/like'], true) ?>" data-id="<?= $answer->id ?>" class="btn btn-primary like">
                                    <i class="fa fa-heart <?= Likes::isRelationExist(\Yii::$app->user->id, $answer->id) ? "like" : ''; ?>"></i>
                                </button>

                                <button type="button" data-url="<?= Url::to(['geeks/answer'], true) ?>" data-id="<?= $answer->id ?>" class="btn btn-primary answer">
                                    <i class="fa fa-reply""></i>
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
    <?php endforeach; ?>
<?php endif; ?>
