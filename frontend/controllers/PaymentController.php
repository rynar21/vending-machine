<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\Queue;
use common\models\SaleRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\plugins\spayplugins\plugins\Encryption;
use common\plugins\spayplugins\plugins\SarawakPay;


class PaymentController extends Controller
{
    public $imodel;
    public $enableCsrfValidation = false;

    public function actionCreateOrder()
    {

        $salerecord_id = $_POST['salerecord_id'];
        $price = $_POST['price'];
        $data = [
            'merchantId' => Yii::$app->spay->merchantId,
            'curType' => 'RM',
            'notifyURL' => 'https://google.com/',
            'merOrderNo' => $salerecord_id,
            'goodsName' => '',
            'detailURL' => "http://localhost:20080/payment/check?id=$salerecord_id",
            'orderAmt' => $price,
            'remark' => '',
            'transactionType' => '1',
        ];
        $data             = json_encode($data, 320);
        //$response_data = Yii::$app->spay->createOrder($data);
        $response_data    = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.preOrder.do', $data);

        if ($response_data) {
            $get_response = json_decode($response_data);
            $referenceNo  = $get_response->{'merOrderNo'};
            $token        = $get_response->{'securityData'};
            return $this->render('/sale-record/request',['referenceNo'=>$referenceNo,'token'=>$token,'id'=>$salerecord_id]);
        }
        else {
            return "false";
        }
    }

    public function actionCallback()
    {
        $request = Yii::$app->request;

        $data = $request->post('formData');

        if ($data) {
            $result = SarawakPay::decrypt($data);
            $result = Json::decode($result);

            $id = ArrayHelper::getValue($result, 'merOrderNo');
            $orderStatus = ArrayHelper::getValue($result, 'orderStatus');

            $model = SaleRecord::find()->where(['order_number' => $id])->one();
            $item_model = item::find()->where(['id' => $model->item_id])->one();

            if ($model!=null)
            {
                if ($orderStatus == SarawakPay::STATUS_SUCCESS) {
                    // change ur system sale record to success
                    //
                    // send open box to queue;
                } else {
                    // change ur system sale record to failed
                }
            }

        }

        return [
            'status' => 0,
        ];
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
        $data          = json_encode($data, 320);
        $string        = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.queryOrder.do', $data);
        $array         = json_decode($string);
        $orderStatus   = $array->{'orderStatus'};
        $orderAmt      = $array->{'orderAmt'};

        if ($model!=null)
        {
            if ($orderStatus == 0)
            {
                return $this->render('/sale-record/create', [
                    'item_model' => $item_model,
                    'model' => $model,
                    'id' => $id,
                ]);
            }
            elseif ($orderStatus == 1)
            {
                $this->add_queue([
                    'store_id' => $model->store_id,
                    'action' => $model->box->hardware_id,
                ]);
                return Yii::$app->runAction('sale-record/paysuccess',['id'=>$id]); //error
                //return $this->redirect(['sale-record/paysuccess','id'=>$id]);
            }
            elseif($orderStatus == 2 || $orderStatus == 4)
            {
                return $this->redirect(['sale-record/payfailed','id' => $id,]);
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
