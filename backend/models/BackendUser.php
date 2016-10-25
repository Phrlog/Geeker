<?php
namespace backend\models;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property string $role
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $subscription
 * @property string $subscribers
 * @property string $avatar
 * @property string $thumbnail
 */

class BackendUser extends \common\models\User
{
    
}