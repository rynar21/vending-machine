<?php

namespace console\controllers;
use Yii;
use common\models\User;
use yii\console\Controller;

class UserController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }

    public function actionCreateAdmin($username,$password)
    {
        $model = new User();
        $model->email = $username.'@gmail.com';
        $model->username = $username;
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
        $model->auth_key = Yii::$app->security->generateRandomString();
        $model->status = User::STATUS_ACTIVE;
        $model->save();
        $auth = Yii::$app->authManager;
        $auth->revokeAll(User::find()->where(['username'=>$username])->one()->id);
        $auth_role = $auth->getRole('admin');
        $auth->assign($auth_role, User::find()->where(['username'=>$username])->one()->id);
        if ($model->save()) {
            echo "ok";
        }
        else {
            echo "false";
        }
    }

}
