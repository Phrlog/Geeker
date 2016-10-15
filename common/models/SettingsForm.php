<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\imagine;
use yii\web\UploadedFile;
use Imagine\Image\ImageInterface;
use yii\imagine\Image;

/**
 * Login form
 */
class SettingsForm extends Model
{
    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $email;

    /**
     * @var UploadedFile
     */
    public $avatar;

    /**
     * @var
     */
    public $filter;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and email are both required
            [['username', 'email'], 'required'],
            [['avatar'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
            [['filter'], 'safe']
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
            'avatar' => 'Выберите аватар',
            'email' => 'Email'
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
            $path = Yii::getAlias('@upload') . '/' . Yii::$app->user->id . '/avatar';

            $this->createDir($path . '/original');
            $this->createDir($path . '/thumbnail');

            $file_name = $this->avatar->baseName . '.' . $this->avatar->extension;

            $this->avatar->saveAs($path . '/original/' . $file_name);
            var_dump($this->filter);
            $image = Image::getImagine()->open($path . '/original/' . $file_name);

            switch ($this->filter) {
                case 1:
                    $image->effects()->negative();
                    break;
                case 2:
                    $image->effects()->gamma(0.7);
                    break;
                case 3:
                    $image->effects()->grayscale();
                    break;
            }
            $image->save($path . '/original/' . $file_name);
            $image = Image::thumbnail($path . '/original/' . $file_name, 120, 120, ImageInterface::THUMBNAIL_INSET);
            $image->save($path . '/thumbnail/' . $file_name, ['quality' => 50]);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return bool
     */
    public function save()
    {
        $this->avatar = UploadedFile::getInstance($this, 'avatar');

        $user = User::findOne(['id' => Yii::$app->user->id]);

        if ($this->upload()) {
            $path = 'upload/' . Yii::$app->user->id . '/avatar';

            $user->avatar = $path . '/original/' . $this->avatar->baseName . '.' . $this->avatar->extension;
            $user->thumbnail = $path . '/thumbnail/' . $this->avatar->baseName . '.' . $this->avatar->extension;
        }

        $user->email = $this->email;
        $user->username = $this->username;

        return $user->save();
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

}
