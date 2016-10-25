<?php

namespace common\models;

use Yii;
use yii\db\Query;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "{{%likes}}".
 *
 * @property integer $user_id
 * @property integer $geek_id
 *
 * @property Geeks $geek
 * @property User $user
 */
class Likes extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%likes}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'geek_id'], 'required'],
            [['user_id', 'geek_id'], 'integer'],
            [['geek_id'], 'exist', 'skipOnError' => true, 'targetClass' => Geeks::className(), 'targetAttribute' => ['geek_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'geek_id' => 'Geek ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeek()
    {
        return $this->hasOne(Geeks::className(), ['id' => 'geek_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $id
     * @param $geek_id
     * @return int|string
     */
    public static function isRelationExist($id, $geek_id)
    {
        return Likes::find()->where(['user_id' => $id, 'geek_id' => $geek_id])->count();
    }

    /**
     * @param $user_id
     * @return array
     */
    public static function getUserLikes($user_id)
    {
        $likes = [];
        $query = new Query();
        $query = $query->select(['geek_id'])->from(Likes::tableName())->where(['user_id' => $user_id])->all();
        for ($i = 0; $i < count($query); $i++) {
            $likes[] = $query[$i]['geek_id'];
        }

        return $likes;
    }

    public static function doLike($user_id, $geek_id) {
        $like = new self();

        if (Geeks::findOne($geek_id) === null) {
            throw new NotFoundHttpException;
        }

        if (Likes::isRelationExist($user_id, $geek_id)) {
            Likes::find()->where(['user_id' => $user_id, 'geek_id' => $geek_id])->one()->delete();
            $option = 'delete';
        } else {
            $like->user_id = $user_id;
            $like->geek_id = $geek_id;
            $like->save();
            $option = 'add';
        }

        return $option;
    }
}
