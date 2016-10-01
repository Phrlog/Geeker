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
            <?php if ($user->status == 0): ?>
                <span class="label label-danger">Забанен</span>
            <?php elseif ($user->status == 10): ?>
                <span class="label label-primary">Активен</span>
            <?php endif; ?>
            <?php if ($user->status == 10): ?>
                <a href="<?= Url::to(['user/ban', 'id' => $user->id]); ?>">
                    Забанить
                </a>
            <?php elseif ($user->status == 0): ?>
                <a href="<?= Url::to(['user/unban', 'id' => $user->id]); ?>">
                    Разбанить
                </a>
            <?php endif; ?>
        </div>
    </div>
<?php endforeach; ?>