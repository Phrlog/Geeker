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
    public $parent_id;

    public function rules()
    {
        return [
            [['text', 'text'], 'required'],
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['parent_id'], 'integer']
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

    public function save()
    {
        $text = Yii::$app->request->post('GeekForm')['text'];

        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        $geek = new Geeks();

        if ($this->upload()) {
            $path = 'upload/' . Yii::$app->user->id;

            $geek->image = $path . '/original/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
            $geek->thumbnail = $path . '/thumbnail/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
        }

        $geek->parent_id = Yii::$app->request->post('GeekForm')['parent_id'];
        $geek->user_id = Yii::$app->user->id;
        $geek->text = $text;

        return $geek->save();
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
            'text' => 'Введите ваш твит:',
            'imageFile' => 'Выберите изображение:',
        ];
    }
}