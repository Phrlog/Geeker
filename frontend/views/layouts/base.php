<?php
/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\MainAsset;
use yii\helpers\Html;
use yii\helpers\Url;

MainAsset::register($this);

$username = Yii::$app->user->id ? Yii::$app->user->identity->findIdentity(Yii::$app->user->id)->username : 'Гость';
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

    <div class="navbar-image" style="background-image: url('/img/1.jpg');background-position: center 40%;"></div>

    <div class="navbar-wrapper container">
        <div class="navbar-header">
            <a class="navbar-brand" href="<?= Url::to(['geeks/index']); ?>"><i class="material-icons">&#xE871;</i> Geeker</a>
        </div>
        <div class="navbar-collapse collapse navbar-responsive-collapse">
            <ul class="nav navbar-nav">
                <li class="active dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown"><?=$username ?><b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <?php if ($username == 'Гость'): ?>
                            <li><a href="<?= Url::to(['site/login']); ?>">Войти</a></li>
                            <li><a href="<?= Url::to(['site/signup']); ?>">Регистрация</a></li>
                        <?php endif; ?>

                        <?php if ($username != 'Гость'): ?>
                            <li><a href="<?= Url::to(['site/logout']); ?>">Выйти</a></li>
                        <?php endif; ?>
                    </ul>
                </li>
                <li class="dropdown">
                    <a href="bootstrap-elements.html" data-target="#" class="dropdown-toggle" data-toggle="dropdown">Твиты <b class="caret"></b></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= Url::to(['geeks/all']); ?>">Все твиты</a></li>
                        <li><a href="<?= Url::to(['geeks/feed']); ?>">Ваша лента</a></li>
                        <li><a href="<?= Url::to(['geeks/create']); ?>">Создать</a></li>
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