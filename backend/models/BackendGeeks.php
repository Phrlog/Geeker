<?php
namespace backend\models;

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

class BackendGeeks extends \common\models\Geeks
{

}