<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class ChangePasswordForm extends Model
{
    public $password;
    public $newPassword;
    public $confirmPassword;
    public $user_id;

    private $_user;

    /**
     * @return array the validation rules.
     */
     public function rules()
     {
         return [
             // password are both required
             [['password','newPassword','confirmPassword'], 'required'],

             ['newPassword', 'string', 'min' => 6],
             //Are two passwords equal?
             ['confirmPassword', 'compare', 'compareAttribute' => 'newPassword'],
             // password is validated by validatePassword()
             ['password', 'validatePassword'],
         ];
     }

     /**
      * Validates the password.
      * This method serves as the inline validation for password.
      * @param string $attribute the attribute currently being validated
      * @param array $params the additional name-value pairs given in the rule
      */

      public function ChangePassword()
      {
          $user = $this->getUser();
          if ($user&&$user->validatePassword($this->password)) {
              $user->setPassword($this->newPassword);
              return $user->save(false);
          }
          else {
              Yii::$app->session->setFlash('danger', 'Incorrect password');
          }
      }

     /**
      * Logs in a user using the provided username and password.
      * @return bool whether the user is logged in successfully
      */

     /**
      * Finds user by [[username]]
      * @return User|null
      */
     protected function getUser()
     {
         if ($this->_user === null) {
             $this->_user = User::findIdentity(Yii::$app->user->identity->id);
         }

         return $this->_user;
     }
     protected function  validatePassword($password)
     {
         if ($this->_user === null) {
             $this->_user = User:: validatePassword($password);
         }

         return $this->_user;
     }
 }
