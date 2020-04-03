<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\Queue;
use common\models\SaleRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\plugins\spay\Encryption;
use common\plugins\spay\SarawakPay;


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
            'notifyURL' => Yii::$app->vm->url.'payment/callback',
            'merOrderNo' => $salerecord_id,
            'goodsName' => '',
            'detailURL' => Yii::$app->vm->url.'payment/check?id='.$salerecord_id,
            'orderAmt' => $price,
            'remark' => '',
            'transactionType' => '1',
        ];
        $response_data = Yii::$app->spay->createOrder($data);

        if ($response_data) {
            $get_response = json_decode($response_data);
            $referenceNo  = $get_response->{'merOrderNo'};
            $token        = $get_response->{'securityData'};
            return $this->render('/sale-record/request',['referenceNo'=>$referenceNo,'token'=>$token,'id'=>$salerecord_id]);
        }

        return "false";
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
            if ($model!=null)
            {
                if ($orderStatus == SarawakPay::STATUS_SUCCESS) {
                    //$model = SaleRecord::findOne(['merOrderNo'=>$id]);
                    $model->success();
                    $this->add_queue([
                        'store_id' => $model->store_id,
                        'action' => $model->box->hardware_id,
                    ]);
                } else {
                    $model->failed();
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
            'merchantId' => Yii::$app->spay->merchantId,
            'merOrderNo' => $id,
        ];
        $response_data = Yii::$app->spay->checkOrder($data);
        $array         = json_decode($response_data);
        $orderStatus   = $array->{'orderStatus'};
        $orderAmt      = $array->{'orderAmt'};

        if ($model)
        {
            if ($orderStatus == SarawakPay::STATUS_PENDING)
            {
                return $this->render('/sale-record/create', [
                    'item_model' => $item_model,
                    'model' => $model,
                    'id' => $id,
                ]);
            }

            if ($orderStatus == SarawakPay::STATUS_SUCCESS)
            {
                Queue::push($model->store_id, $model->box->hardware_id)

                return $this->redirect(['sale-record/paysuccess', 'id' => $id]);
            }

            return $this->redirect(['sale-record/payfailed', 'id' => $id,]);
        }

        throw new NotFoundHttpException("Requested item cannot be found.");
    }
}
