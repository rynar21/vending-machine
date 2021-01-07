<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

class SignUp extends User
{
  public $username;
  public $email;
  public $password;
  public $confirm_password;
  public $id;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['confirm_password', 'string', 'min' => 6],
        ];
    }
    /**
     * Signs user up.
     *
     * @return bool whether the creating new account was successful and email was sent
     */
    public function SignUp()
    {
        if (!$this->validate()) {
            return null;
        }
        $user = new User();

        if ($this->password == $this->confirm_password) {
            $user->email = $this->email;
            $user->username = $this->email;
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->generateEmailVerificationToken();
            $result = $user->save();
            $this->id = $user->id;
            return $result;
        }
        return Yii::$app->session->setFlash('danger', 'Incorrect password');
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
