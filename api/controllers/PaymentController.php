<?php
namespace api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;
use common\models\SaleRecord;
use yii\helpers\Url;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * Site controller
 */
class PaymentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors'  => [
                // restrict access to domains:
                'Origin'                           => ['*'],
                'Access-Control-Request-Method'    => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Request-Headers'   => ['*'],
                'Access-Control-Max-Age'           => 3600,                 // Cache (seconds)
            ],
        ];

        return $behaviors;
    }

    public function actionOptions()
    {
        if (Yii::$app->getRequest()->getMethod() !== 'OPTIONS') {
            Yii::$app->getResponse()->setStatusCode(405);
        }

        $headers = Yii::$app->getResponse()->getHeaders();
        $headers->set('Access-Control-Allow-Origin', '*');
        $headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, HEAD, OPTIONS');
        $headers->set('Access-Control-Allow-Headers', 'Authorization');
        $headers->set('Access-Control-Max-Age', '3600');
	}


    public function actionView($id)
    {

    }

    public function actionReference($payandgo_order_number,$vm_order_number)
    {
        $model =  SaleRecord ::find()->where(['order_number' => $vm_order_number])->one();
        if ($model)
        {
            $model->updateReference($payandgo_order_number);
            return true;
        }

        return false;
    }

    public function actionSignalling()
    {
        $order_id = Yii::$app->request->getBodyParam('order_id');


        $order = SaleRecord::findone(['unique_id' => $order_id]);

        if ($order)
        {
            $order->queryOrderStatus();
        }

        return false;
    }


}
