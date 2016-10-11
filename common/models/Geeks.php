<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use yii\db\ActiveRecord;

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
 * @property User $user
 */
class Geeks extends \yii\db\ActiveRecord
{
    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $count;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%geeks}}';
    }

    /**
     * Add date before publication
     *
     * @return array
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => '\yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'text'], 'required'],
            [['user_id', 'parent_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['text', 'image', 'thumbnail'], 'string', 'max' => 255],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Geeks::className(), 'targetAttribute' => ['parent_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'text' => 'Text',
            'image' => 'Image',
            'thumbnail' => 'Thumbnail',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Geeks::className(), ['id' => 'parent_id']);
    }

    public static function getUserGeeks($id)
    {
        $geeks = Geeks::find()->select(['geeks.*', 'COUNT(likes.geek_id) as count'])
            ->join('INNER JOIN', User::tableName(),'user.id = geeks.user_id')
            ->join('LEFT JOIN', Likes::tableName(), 'likes.geek_id = geeks.id')
            ->where(['geeks.user_id' => $id])
            ->groupBy(['geeks.id'])
            ->orderBy(['geeks.created_at' => SORT_DESC])
            ->all();

        return $geeks;
    }

}
