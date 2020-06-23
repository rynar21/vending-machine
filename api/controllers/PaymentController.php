<?php
namespace api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;

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


}
