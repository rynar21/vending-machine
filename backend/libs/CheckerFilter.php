<?php

namespace backend\libs;


use backend\models\AdminSession;
use backend\controllers\SiteController;
use Yii;
use yii\base\ActionFilter;
use yii\web\UnauthorizedHttpException;
use yii\helpers\Url;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use app\components\widgets\Alert;




class CheckerFilter extends ActionFilter
{
    public function beforeAction($action)
    {
        //rbac访问控制
        $controllerID = Yii::$app->controller->id;
        $actionID = $action->id;
        $permissionName = $controllerID . '/' . $actionID;
        //登录  所有操作都虚经过过滤器控制输出
        if(!Yii::$app->user->isGuest && $actionID != 'logout')
        {
            $id = Yii::$app->user->id;
            $session = Yii::$app->session;
            $username = Yii::$app->user->identity->username;
            $tokenSES = $session->get(md5(sprintf("%s&%s",$id,$username))); //取出session中的用户登录token
            $sessionTBL = AdminSession::findOne(['id' => $id]);
            if (empty($sessionTBL->session_token)) {
                return parent::beforeAction($action);
            }
            $tokenTBL = $sessionTBL->session_token;
            if($tokenSES != $tokenTBL)  //如果用户登录在 session中token不同于数据表中token
            {

                Yii::$app->user->logout();
                //Yii::$app->session->setFlash('error', 'Your account has already been logged in elsewhere');
                //执行登出操作
                echo "<script>alert('Your account has been logged in elsewhere');window.location.href='http://localhost/vending-machine/backend/web/site/login';</script>";
                // Yii::$app->run();
                // Yii::$app->response->redirect(Url::to(['site/login'],Yii::$app->session->setFlash('error', 'Your account has already been logged in elsewhere')));
                //Yii::$app->request(Yii::$app->session->setFlash('error', 'Your account has already been logged in elsewhere'));

            }
        }
        return parent::beforeAction($action);
    }
}
