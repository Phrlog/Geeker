<?php
/* @var $this yii\web\View */
/* @var array $users common\models\User */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<?php foreach ($users as $user): ?>

    <div class="main-box clearfix">

        <header class="main-box-header clearfix">
            <h2><?= Html::encode($user->username) ?></h2>
        </header>

        <div class="main-box-body clearfix">
            <a href="<?= Url::to(['user/ban', 'id' => $user->id]); ?>">
                <i class="fa fa-trash-o"></i>
                Забанить
            </a>
        </div>
    </div>

<?php endforeach; ?>