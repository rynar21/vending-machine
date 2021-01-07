<?php
namespace api\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\rest\Controller;
use common\models\Item;
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
            'class' => \yii\filters\Cors::class,
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

    // public function actionReference($payandgo_order_number,$vm_order_number)
    // {
    //     $model =  SaleRecord ::find()->where(['order_number' => $vm_order_number])->one();
    //     if ($model)
    //     {
    //         $model->updateReference($payandgo_order_number);
    //         return true;
    //     }

    //     return false;
    // }

    public function actionSignalling()
    {
        $order_id = Yii::$app->request->getBodyParam('order_id');

        $order = SaleRecord::findOne(['unique_id' => $order_id]);

        if ($order)
        {
            $order->executeUpdateStatus();
        }
        
        return [
           'data' => [
               'update' => 'ok',
           ]
       ];

    }

    // public function actionCreate()
    // {
    //     $item_id        = Yii::$app->request->getBodyParam('item_id');
    //     $reference_no   = Yii::$app->request->getBodyParam('reference_no');

    //     $item = Item::findOne($item_id);

    //     if ($item)
    //     {
    //         if ($item->getIsAvailable())
    //         {
    //             $model = new SaleRecord();
    //             // 创建 新订单
    //             $model->item_id      = $item->id;
    //             $model->order_number = $item->store->prefix . $item->box->code . time();
    //             $model->box_id       = $item->box_id;
    //             $model->store_id     = $item->store_id;
    //             $model->sell_price   = $item->price;
    //             $model->unique_id    = $reference_no;
    //             $model->store_name   = $item->store->name;
    //             $model->item_name    = $item->name;
    //             $model->box_code     = $item->store->prefix . $item->box->code;
    //             $model->status       = SaleRecord::STATUS_INIT;
    //             $model->save();

    //             return $model;
    //         }

    //         return [
    //             'error' => 'Item is not available for purchase',
    //         ];
    //     }

    //     return [
    //         'error' => 'Item not found',
    //     ];
    // }
}
