<?php
namespace frontend\models;

use yii\db\Query;
use common\models\User;
use common\models\Subscription;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $subscription
 * @property string $subscribers
 * @property string $avatar
 * @property string $thumbnail
 */

class FrontendUser extends \common\models\User
{
    /**
     * @param $id
     * @param array $param
     * @return array|bool
     */
    public static function getUsersId($id, array $param)
    {
        $users_id = false;

        $query = new Query;
        $query->select($param['select'])
            ->from('subscription')
            ->where([$param['where'] => $id]);
        $users = $query->all();
        for ($i = 0; $i < count($users); $i++){
            $users_id[] = $users[$i][$param['select']];
        }

        return $users_id;
    }

    /**
     * If $id === true, return all users.
     * If $id === false, return empty array
     * Else, return users with $id
     *
     * @param array|bool|int $id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getUsersById($id = true)
    {
        $users =  parent::find()
            ->select(['user.*', 'count(distinct s.subscribe_id) as subscriptions', ' count(distinct p.user_id) as subscribers'])
            ->join('LEFT JOIN', [Subscription::tableName(). ' s'], 's.user_id = user.id')
            ->join('LEFT JOIN', [Subscription::tableName(). ' p'], 'p.subscribe_id = user.id');

        if ($id === true) {
            return $users->groupBy(['user.id'])->all();
        } elseif ($id === false) {
            return [];
        }

        return $users->where(['user.id' => $id])->groupBy(['user.id'])->all();
    }

    /**
     * Get subscriptions id of user by his id
     *
     * @param $user_id
     * @return array
     */
    public static function getSubscribersId($user_id) {
        $param = ['select' => 'subscribe_id', 'where' => 'user_id'];
        $users_id = self::getUsersId($user_id, $param);
        return  is_array($users_id) ? $users_id : [];
    }

}