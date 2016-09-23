<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php foreach ($geeks as $geek): ?>

    <div class="main-box clearfix">
        <header class="main-box-header clearfix">
            <h2><?= Html::encode($geek->text) ?></h2>
        </header>
        <div class="main-box-body clearfix">
            <a href="<?= Url::to(['geeks/edit', 'id' => $geek->id]); ?>" >
                <i class="fa fa-edit"></i>
                Изменить
            </a>
            <a href="<?= Url::to(['geeks/delete', 'id' => $geek->id]); ?>">
                <i class="fa fa-trash-o"></i>
                Удалить
            </a>
        </div>
    </div>

<?php endforeach; ?>