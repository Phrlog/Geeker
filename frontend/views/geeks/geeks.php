<?php
/* @var $this yii\web\View */
use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php foreach ($geeks as $geek): ?>

<div class="col-sm-8 blog-main">
    <div class="row">
        <div class="col-sm-6">
            <section class="blog-post">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="blog-post-meta">
                            <span class="label label-light label-primary">Пользователь</span>
                            <p class="blog-post-date pull-right">Дата</p>
                        </div>
                        <div class="blog-post-content">
                            <a href="<?= Url::to(['view', 'id' => $geek->id]); ?>">
                                <h2 class="blog-post-title"><?= $geek->text ?></h2>
                            </a>
                            <p></p>
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