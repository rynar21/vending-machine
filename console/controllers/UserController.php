<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use common\models\Box;
use common\models\User;
use common\models\Product;
use common\models\Store;
use common\models\Item;
use common\models\Queue;
use common\models\Finance;
use yii\helpers\ArrayHelper;
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
