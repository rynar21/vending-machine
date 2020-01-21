<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;
use backend\models\AdminSession;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $user_id;
    public $rememberMe = true;
    public $verifyCode;
    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],

            ['verifyCode', 'captcha'],
        ];
    }
    public function attributeLabels() {
         return [
              'verifyCode' => '', //验证码的名称，根据个人喜好设定
         ];
     }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if ($user && $user->validatePassword($this->password)) {
                if (!Yii::$app->authManager->checkAccess($user->id,'user')) {
                    $this->addError($attribute, "You don't have enough authority.");
                }
            }
            else {
                $this->addError($attribute, 'Incorrect username or password');
            }

        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        return false;
    }

    /**
     * Finds user by [[username]]
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
    public function insertSession($id,$sessionToken)
   {
       $loginAdmin = AdminSession::findOne(['id' => $id]); //查询admin_session表中是否有用户的登录记录
       if(!$loginAdmin){ //如果没有记录则新建此记录
           $sessionModel = new AdminSession();
           $sessionModel->id = $id;
           $sessionModel->session_token = $sessionToken;
           $result = $sessionModel->save();
       }else{          //如果存在记录（则说明用户之前登录过）则更新用户登录token
           $loginAdmin->session_token = $sessionToken;
           $result = $loginAdmin->update();
       }
       return $result;
   }


    // protected function getId()
    // {
    //
    //     $this->_user=User::find()->where(['username' =>$this->username])->one();
    //
    //     return $this->_user;
    // }
}
