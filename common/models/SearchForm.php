<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class SearchForm extends Model
{
    /**
     * @var
     */
    public $username;

    /**
     * @var
     */
    public $_user;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username'], 'safe'],
        ];
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }

    public function attributeLabels()
    {
        return [
            'username' => 'Имя пользователя',
        ];
    }
}
