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
        $time = $request->get('time');
        $price = $request->get('price');

        return $this->render('/sale-record/loading',[
            'id' => $id,
            'time' => $time,
            'price' => $price,
        ]);
    }
    // 如果产品ID没有在于 SaleRecord 表里：创新新订单
    // 运行 购买流程
    public function actionCreate($id,$time)
    {
        $salerecord_model = SaleRecord::find()->where([
            'item_id' => $id,
            'status' => SaleRecord::STATUS_PENDING
        ])->one();

        if ($salerecord_model)
        {
            return $this->redirect([
                'item/view',
                'id' => $salerecord_model->item_id,
            ]);
        }

        $item_model = Item::findOne($id);   // 寻找 Item
        $model = new SaleRecord();

        if ($item_model)
        {
            if(empty($model->findOne(['item_id' => $id])) || $model->find()->orderBy([
                'id' => SORT_DESC
            ])->where([
                'item_id' => $id,
                'status' => SaleRecord::STATUS_FAILED
            ])->one())
            {
                // 创建 新订单
                $model->item_id      = $id;
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
            }//

            $salerecord = SaleRecord::find()->where([
                'item_id' => $id,
                'status' => SaleRecord::STATUS_PENDING
            ])->orderBy([
                'created_at' => SORT_ASC,
                'id' => SORT_ASC
            ])->one();

            if ($salerecord)
            {
                if ($model->id == $salerecord->id)
                {
                    return $this->render('/sale-record/loadings',[
                        'salerecord_id' => $model->order_number,
                        'price' =>$item_model->price,
                    ]);
                    //return $this->redirect(['check','id'=>$model->id]);
                }
            }

            return "Order or product does not exist";
        }

        throw new NotFoundHttpException("Requested item cannot be found.");
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

            if ($model!=null)
            {
                if ($orderStatus == SarawakPay::STATUS_SUCCESS)
                {
                    $model->success();
                    Queue::push($model->store_id, $model->box->hardware_id);
                }

                else
                {
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
        $model      = SaleRecord::find()->where(['order_number' => $id])->one();
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
