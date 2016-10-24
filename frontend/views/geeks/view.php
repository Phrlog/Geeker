<?php
/* @var $this yii\web\View */
/* @var array $geek common\models\Geeks */
/* @var array $answers common\models\Geeks */
/* @var $user common\models\User */
/* @var array  $likes */

use frontend\assets\LikesAsset;
use frontend\assets\AnswerAsset;

LikesAsset::register($this);
AnswerAsset::register($this);

?>
<div class="col-sm-12">
    <?= $this->render('/common/_geek', ['likes' => $likes, 'geek' => $geek, 'username' => $geek->getUser()->select(['username'])->one()->username]) ?>
</div>

<?php if ($answers != null): ?>
    <?php foreach ($answers as $answer): ?>
        <div class="col-sm-8">
            <?= $this->render('/common/_geek', ['likes' => $likes, 'geek' => $answer, 'username' => $answer->username]) ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>
