<?php
namespace backend\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Login form
 */
class AdminPasswordForm extends Model
{
    public $username;
    public $password;
    public $user_id;
    public $rememberMe = true;
    public $newpassword;
    public $confirmpassword;


    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password','newpassword','confirmpassword'], 'required'],
            // rememberMe must be a boolean value
            ['password', 'validatePassword'],
            // password is validated by validatePassword()
            [['newpassword','confirmpassword','password'],'string', 'min' => 6],


            [['newpassword','confirmpassword'],'changePassword'],


            // ['newpassword','required'],
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
        // $id = Yii::$app->user->identity->id;
        // $admin=  User::findIdentity($id);
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
    public function changePassword(){
        $id = Yii::$app->user->identity->id;
        $user=  User::findIdentity($id);
        $password = $user->password;
        if(Yii::$app->getSecurity()->validatePassword($this->password, $password)){
            if($this->$newpassword == $this->$confirmpassword){
                $newPass = Yii::$app->getSecurity()->generatePasswordHash($this->$newpassword);
                $user->password = $newPass;
                if($user->save()){
                    return true;
                }else{
                    return false;
                }
            }else{
                $this->setFlash($attribute,'Two new passwords are not equal');
                return false;

            }
        }else{
            $this->setFlash($attribute,'Old password error');
            return false;
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

    // protected function getId()
    // {
    //
    //     $this->_user=User::find()->where(['username' =>$this->username])->one();
    //
    //     return $this->_user;
    // }
}
