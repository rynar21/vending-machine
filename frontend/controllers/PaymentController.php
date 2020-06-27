<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\Store;
use common\models\Box;
use common\models\Queue;
use yii\helpers\Json;
use common\models\SaleRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use common\components\SarawakPay;


class PaymentController extends Controller
{
    public $imodel;
    public $enableCsrfValidation = false;

    //自动生成订单
    public function actionGenerate()
    {
        $request = \Yii::$app->request;//获取商品信息
        $id = $request->get('id');
        $price = $request->get('price');

        return $this->render('/sale-record/loading',[
            'id' => $id,
            //'time' => $time,
            'price' => $price,
        ]);
    }


    // 如果产品ID没有在于 SaleRecord 表里：创新新订单
    // 运行 购买流程
    public function actionCreate($id)
    {
        if ($record = $this->generateOrder($id)) {

            return   $this->redirect([
                    'payment/demo',
                    'record_id' => $record->id,
                ]);
        }
        return  $this->redirect([
            'item/view',
            'id' => $id,
        ]);

        throw new NotFoundHttpException("Requested item cannot be found.");
    }

    public function actionDemo($record_id)
    {
        $model = SaleRecord::findOne($record_id);
        $data =  Yii::$app->payandgo->checkOrder($model->unique_id);
        if ($data)
        {
            $data = json_decode($data,true);
            $orderStatus = ArrayHelper::getValue($data, 'data.status', null);
            
            if (empty($orderStatus)) {

                return   $this->render('/sale-record/loadings',[
                    'model' => $model,
                ]);
            }

            if (Yii::$app->payandgo->getIsFinalStatus($orderStatus))
            {
                if (Yii::$app->payandgo->getIsPaymentSuccess($orderStatus))
                {
                     $model->success();
                }

                $model->failed();
            }
            return   $this->render('/sale-record/loadings',[
                'model' => $model,
            ]);
        }
        return   $this->render('/sale-record/loadings',[
            'model' => $model,
        ]);
    }

    public function generateOrder($id)
    {

        $item_model = Item::findOne($id);
           // 寻找 Item
        if ($item_model)
        {
            if($item_model->status != Item::STATUS_SOLD && $item_model->status != Item::STATUS_LOCKED )
            {
                return $this->generateOrderNumber($item_model);
            }//

            return false;
        }

    }

    public function generateOrderNumber($item_model)
    {
        $time = time();
        $model = new SaleRecord();
        // 创建 新订单
        $model->item_id      = $item_model->id;
        $model->order_number = $item_model->store->prefix.$item_model->box->code.$time;
        $model->box_id       = $item_model->box_id;
        $model->store_id     = $item_model->store_id;
        $model->sell_price   = $item_model->price;
        $model->unique_id    = $time;
        $model->store_name   = $item_model->store->name;
        $model->item_name    = $item_model->name;
        $model->box_code     = $item_model->store->prefix.$item_model->box->code;
        $model->save();
        $model->pending();
        return $model;
    }

    ///spay端的创建订单
    public function actionCreateOrder()
    {
        $salerecord_id = $_POST['salerecord_id'];
        $price = $_POST['price'];
        $data = [
            'curType'           => 'RM',
            'notifyURL'         => Yii::getAlias('@urlFrontend/payment/callback'),
            'merOrderNo'        => $salerecord_id,
            'goodsName'         => '',
            'detailURL'         => Yii::getAlias('@urlFrontend/payment/check?id=').$salerecord_id,
            'orderAmt'          => $price,
            'remark'            => '',
            'transactionType'   => '1',
        ];

        $response_data = Yii::$app->spay->createOrder($data);

        if ($response_data)
        {
            $get_response = json_decode($response_data);
            $referenceNo  = $get_response->{'merOrderNo'};
            $token        = $get_response->{'securityData'};

            return $this->render('/sale-record/request',[
                'referenceNo' => $referenceNo,
                'token' => $token,
                'id' => $salerecord_id
            ]);
        }

        return "false";
    }


    public function actionCallback()
    {
        $request = Yii::$app->request;

        $data = $request->post('formData');

        if ($data)
        {
            $result = Yii::$app->spay->decrypt($data);
            $result = Json::decode($result);

            $id          = ArrayHelper::getValue($result, 'merOrderNo');
            $orderStatus = ArrayHelper::getValue($result, 'orderStatus');

            $model = SaleRecord::find()->where(['order_number' => $id])->one();

            $model->executeUpdateStatus();
        }

        return [
            'status' => 0,
        ];
    }


    // 判断 交易订单 的状态
    public function actionCheck($id)
    {
        $model = SaleRecord::find()
            ->where(['order_number' => $id])
            ->one();

        $item_model = item::find()
            ->where(['id' => $model->item_id])
            ->one();

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
                return $this->redirect([
                    'success', 'id' => $id
                ]);
            }

            return $this->redirect([
                'failed',
                'id' => $id,
            ]);
        }

        throw new NotFoundHttpException("Requested item cannot be found.");
    }

    public function actionCancel($id)
    {
        $model = SaleRecord::findOne(['id' => $id]);
        $model->failed();

        return $this->redirect([
            'store/view',
            'id' => $model->store_id
        ]);
    }


    public function actionSuccess($id)
    {
        $model = SaleRecord::findOne(['order_number'=>$id]);

        if ($model)
        {
            return $this->render('/sale-record/success',[
                'model'=>$model,
            ]);
        }

    }


    public function actioFailed($id)
    {
        $model = SaleRecord::findOne(['order_number'=> $id]);

        if ($model)
        {
            return $this->render('/sale-record/failed',[
                'model'=>$model,
            ]);
        }

    }


}
