<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use yii\imagine;

class GeekForm extends Model
{
    public $text;

    /**
     * @var UploadedFile
     */
    public $imageFile;


    public function rules()
    {
        return [
            [['text', 'text'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg']
        ];
    }

    /**
     * Upload image and thumbnail
     *
     * @return bool
     */
    public function upload()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('@upload') . '/' . Yii::$app->user->id;

            $this->createDir($path . '/original');
            $this->createDir($path . '/thumbnail');

            $file_name = $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $this->imageFile->saveAs($path . '/original/' . $file_name);

            imagine\Image::thumbnail( $path . '/original/' . $file_name, 240, 320)
                ->save($path . '/thumbnail/' . $file_name, ['quality' => 50]);

            return true;
        } else {
            return false;
        }
    }

    /**
     * Create dir
     *
     * @param $path
     */
    public function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }

    public function attributeLabels()
    {
        return [
            'imageFile' => 'Выберите изображение:'
        ];
    }
}