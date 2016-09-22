<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\MainAsset;
use yii\helpers\Html;
use yii\helpers\Url;

MainAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <?= Html::csrfMetaTags() ?>
    <link rel="icon" href="favicon.ico">
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="navbar navbar-material-blog navbar-primary navbar-absolute-top">

    <div class="navbar-image" style="background-image: url('/img/splash.jpg');background-position: center 40%;"></div>

    <div class="navbar-wrapper container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= Url::to(['index']); ?>"><i class="material-icons">&#xE871;</i> Geeker</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li class="active dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Твиты <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="home-fashion.html">Fashion</a></li>
                        <li><a href="home-food.html">Food</a></li>
                        <li><a href="home-music.html">Music</a></li>
                        <li><a href="home-photography.html">Photography</a></li>
                        <li><a href="home-technology.html">Technology</a></li>
                        <li><a href="home-travel.html">Travel</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Мой профиль <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="filter-category.html">Category</a></li>
                        <li><a href="filter-author.html">Author</a></li>
                        <li><a href="filter-date.html">Date</a></li>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Друзья <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="post-image.html">Image post</a></li>
                        <li><a href="post-video.html">Video post</a></li>
                    </ul>
                </li>
                <li><a href="page-about.html">О нас</a></li>
                <li><a href="page-contact.html">Контакты</a></li>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#"><i class="fa fa-twitter"></i></a></li>
            </ul>
        </div>
    </div>
</div>

<div class="container blog-content">
    <?= $content ?>
</div>

<button class="material-scrolltop info" type="button"></button>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>