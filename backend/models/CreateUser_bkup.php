<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class CreateUser extends User
{
  public $username;
  public $email;
  public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()//规则

    {
        return [
        //     [['id'], 'integer'],
        //     [['username'], 'safe'],
        // ];
        ['username', 'trim'],
        ['username', 'required'],
        ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
        ['username', 'string', 'min' => 2, 'max' => 255],

        ['email', 'trim'],
        ['email', 'required'],
        ['email', 'email'],
        ['email', 'string', 'max' => 255],
        ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

        ['password', 'required'],
        ['password', 'string', 'min' => 6],
    ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function createUser()
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        return $user->save() && $this->sendEmail($user);

    }

    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . ' robot'])
            ->setTo($this->email)
            ->setSubject('Account registration at ' . Yii::$app->name)
            ->send();
    }

}

?>
