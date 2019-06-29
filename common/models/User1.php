<?php
namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\Security;

/**
 * This is the model class for table "tbl_user".
 *
 * @property string $operator_id
 * @property string $operator_name
 * @property string $operator_password
 */
class User extends ActiveRecord implements IdentityInterface
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['operator_name', 'operator_password'], 'required'],
            [['operator_name', 'operator_password'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'operator_id' => 'Operator ID',
            'operator_name' => 'Username',
            'operator_password' => 'Password'
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}isset
     */
    public static function findIdentity($id)
    {
        return isset($this->$users[$id]) ? new static($this->$users[$id]) : null;
    }

    /**
     * Finds user by username

     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {

        foreach ($this->$users as $user)
        {
            // strcasecmp -> compare 2 given strings
            // ===： 检查操作数 & 数值是否一致
            if (strcasecmp($user['username'], $username) === 0)
            {
                return new static($user);
            }
        }
        return null;
    }

    /**
     * Validates password
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
