<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%subscription}}".
 *
 * @property integer $user_id
 * @property integer $subscribe_id
 *
 * @property User $subscribe
 * @property User $user
 */
class Subscription extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%subscription}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'subscribe_id'], 'required'],
            [['user_id', 'subscribe_id'], 'integer'],
            [['subscribe_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['subscribe_id' => 'id']],
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
            'subscribe_id' => 'Subscribe ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSubscribe()
    {
        return $this->hasOne(User::className(), ['id' => 'subscribe_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public static function isRelationExist($id, $sub_id)
    {
        return Subscription::find()->where(['user_id' => $id, 'subscribe_id' => $sub_id])->count();
    }
}
