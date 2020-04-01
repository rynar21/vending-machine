<?php

namespace frontend\controllers;

use Yii;
use mpdf;
use common\models\Store;
use common\models\Item;
use common\models\Box;
use common\models\Queue;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\authclient\signature\BaseMethod;
use common\plugins\spayplugins\plugins\Encryption;
use common\plugins\spayplugins\plugins\SarawakPay;


// BoxController implements the CRUD actions for Box model.
class PaymentController extends Controller
{
    public $imodel;
    public $enableCsrfValidation = false;
    public function actionPaycheck()
    {


        // return "123";
        // die();
        //$request = \Yii::$app->request;
        $salerecord_id = $_POST['salerecord_id'];
        $price = $_POST['price'];
        $data = [
             'merchantId' => 'M100001040',
             'curType' => 'RM',
             'notifyURL' => 'https://google.com/',
             'merOrderNo' => $salerecord_id,
             'goodsName' => '',
             'detailURL' => "http://localhost:20080/payment/check?id=$salerecord_id",
             'orderAmt' => $price,
             'remark' => '',
             'transactionType' => '1',
        ];
        $data          = json_encode($data, 320);
        $response_data = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.preOrder.do', $data);
        if ($response_data) {

            $get_response = json_decode($response_data);
            $referenceNo  = $get_response->{'merOrderNo'};
            $token        = $get_response->{'securityData'};
            return $this->render('sale-record/request',['referenceNo'=>$referenceNo,'token'=>$token,'id'=>$salerecord_id]);
        }

    }



    // 判断 交易订单 的状态
    public function actionCheck($id)
    {
        $model = SaleRecord::find()->where(['order_number' => $id])->one();
        $item_model = item::find()->where(['id' => $model->item_id])->one();
        $data = [
             'merchantId' => 'M100001040',
             'merOrderNo' => $id,
        ];
        $data      = json_encode($data, 320);
        $string    = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.queryOrder.do', $data);
        $array     = json_decode($string);
        $orderStatus   = $array->{'orderStatus'};
        $orderAmt      = $array->{'orderAmt'};
        //print_r($orderStatus);
        if ($model!=null)
        {
            if ($orderStatus == 0) {
                return $this->render('sale-record/create', [
                    'item_model' => $item_model,
                    'model' => $model,
                    'id' => $id,
                ]);
            }
            elseif ($orderStatus == 1) {
                $this->add_queue([
                    'store_id'=>$model->store_id,
                    'action' =>$model->box->hardware_id,
                ]);
                return $this->runAction('sale-record/paysuccess',['id'=>$id]);

                // return $this->redirect(['paysuccess',  //error
                //        'id'=>$id,
                //    ]);
            }
            elseif($orderStatus == 2 || $orderStatus == 4) {
                return $this->redirect(['sale-record/payfailed',
                       'id' => $id,
                ]);
            }
            else
            {
                throw new NotFoundHttpException("Requested item cannot be found.");
            }
        }
        else
        {
            throw new NotFoundHttpException("Requested item cannot be found.");
        }
    }

    public function add_queue($array)
    {
        $store_id = ArrayHelper::getValue($array,'store_id',0);
        $action = ArrayHelper::getValue($array,'action',Null);
        $priority = ArrayHelper::getValue($array,'priority',Null);
        $model = new Queue();
        $model->store_id = $store_id;
        $model->action = $action;
        $model->priority = $priority;
        $model->save();
    }

}
