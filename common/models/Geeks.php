<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%geeks}}".
 *
 * @property integer $id
 * @property string $text
 * @property string $image
 * @property string $thumbnail
 */
class Geeks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%geeks}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text'], 'required'],
            [['text'], 'string', 'max' => 20000],
            [['image'], 'string', 'max' => 255],
            [['thumbnail'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text' => 'Text',
            'image' => 'Image',
            'thumbnail' => 'Thumbnail'
        ];
    }
}
