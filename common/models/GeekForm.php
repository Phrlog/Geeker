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

    public function upload()
    {
        if ($this->validate()) {
            $path = Yii::getAlias('uploads/');
            $this->createDir($path);

            $file_name = $this->imageFile->baseName . '.' . $this->imageFile->extension;

            $this->imageFile->saveAs('uploads/' . $file_name);

            $path = Yii::getAlias('uploads/thumbnail/');
            $this->createDir($path);

            imagine\Image::thumbnail( 'uploads/' . $file_name, 240, 320)
                ->save('uploads/thumbnail/' . $file_name, ['quality' => 50]);

            return true;
        } else {
            return false;
        }
    }

    public function createDir($path)
    {
        if (!file_exists($path)) {
            mkdir($path, 0775, true);
        }
    }
}