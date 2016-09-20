<?php
namespace common\models;

use yii\base\Model;

class GeekForm extends Model
{
    public $text;

    public function rules()
    {
        return [
            [['text', 'text'], 'required']
        ];
    }

}