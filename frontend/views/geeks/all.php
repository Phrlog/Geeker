<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */

use yii\helpers\Html;
use yii\helpers\Url;
use Yii;
?>
<?php foreach ($geeks as $geek): ?>

<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-6">
            <section class="blog-post">
                <div class="panel panel-default">

                    <?php if ($geek->thumbnail): ?>
                    <?= Html::img(Yii::$app->urlManagerBackend->createUrl($geek->image), ['class' => "img-responsive"]) ?>
                    <?php endif; ?>

                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <span class="label label-light label-primary"><?= $geek->getAuthor()->username ?></span>
                            <p class="blog-post-date pull-right"><?= $geek->updated_at ?></p>
                        </div>
                        <div class="blog-post-content">
                            <a href="<?= Url::to(['view', 'id' => $geek->id]); ?>">
                                <h2 class="blog-post-title"><?= Html::encode($geek->text) ?></h2>
                            </a>
                            <p></p>
                            <button type="button" class="btn btn-primary"><i class="fa fa-heart"></i></button>
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