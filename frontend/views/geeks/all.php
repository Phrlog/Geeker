<?php
/* @var $this yii\web\View */
/* @var array $geeks common\models\Geeks */
/* @var $user common\models\User */
/* @var array  $likes */

use frontend\assets\AnswerAsset;
use frontend\assets\LikesAsset;
LikesAsset::register($this);
AnswerAsset::register($this);

?>
<?php foreach ($geeks as $geek): ?>
    <div class="col-sm-12 blog-main">
        <div class="row">
            <div class="col-sm-6">
                <?= $this->render('/common/_geek', ['likes' => $likes, 'geek' => $geek, 'username' => $geek->username]) ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>