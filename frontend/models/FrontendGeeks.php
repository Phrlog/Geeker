<?php
namespace frontend\models;

use common\models\Subscription;
use common\models\Likes;
use common\models\User;

/**
 * This is the model class for table "{{%geeks}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $parent_id
 * @property string $text
 * @property string $image
 * @property string $thumbnail
 * @property string $created_at
 * @property string $updated_at
 *
 * @property FrontendUser $user
 */
class FrontendGeeks extends \common\models\Geeks
{
    /**
     * @param $user_id
     * @param int $sort
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUserFeed($user_id, $sort = SORT_DESC) {
        $geeks = parent::find()->select(['geeks.*', 'user.username', 'COUNT(likes.geek_id) as count'])
            ->join('INNER JOIN', User::tableName(), 'user.id = geeks.user_id')
            ->join('INNER JOIN', Subscription::tableName(), 'subscription.subscribe_id = user.id')
            ->join('LEFT JOIN', Likes::tableName(), 'likes.geek_id = geeks.id')
            ->where(['subscription.user_id' => $user_id])
            ->orWhere(['geeks.user_id' => $user_id])
            ->groupBy(['geeks.id'])
            ->orderBy(['geeks.created_at' => $sort])
            ->all();

        return $geeks !== null ? $geeks: [];

    }
}