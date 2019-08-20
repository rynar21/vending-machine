<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * OperatorSearch represents the model behind the search form of `common\models\Operator`.
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     */
     public $username;
     public $email;
     public $password;


     /**
      * {@inheritdoc}
      */
     public function rules()
     {
         return [
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
     public function signup()
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

     /**
      * Sends confirmation email to user
      * @param User $user user model to with email should be send
      * @return bool whether the email was sent
      */
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
    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query =User::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }

}
