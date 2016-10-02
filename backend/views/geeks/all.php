<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<?php foreach ($geeks as $geek): ?>
    <div class="main-box clearfix">
        <div class="info">
            <a href="#"><span class="label label-primary"><?= Html::encode($geek->getUser()->select(['username'])->one()->username) ?></span></a>
            <span class="label label-info"><?= $geek->updated_at ?></span>
        </div>
        <header class="main-box-header clearfix">
            <h2><?= Html::encode($geek->text) ?></h2>
        </header>
        <?php if ($geek->thumbnail): ?>
            <?= Html::img(Yii::$app->urlManagerFrontend->createUrl($geek->thumbnail)) ?>
        <?php endif; ?>
        <div class="main-box-body clearfix">
            <a href="<?= Url::to(['geeks/edit', 'id' => $geek->id]); ?>">
                <i class="fa fa-edit"></i>
            </a>
            <a href="<?= Url::to(['geeks/delete', 'id' => $geek->id]); ?>">
                <i class="fa fa-trash-o"></i>
            </a>
        </div>
    </div>
<?php endforeach; ?>