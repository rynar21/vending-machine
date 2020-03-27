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
 // require_once('app\plugins\Encryption.php');
 // require_once('app\plugins\SarawakPay.php');
 //SaleRecordController implements the CRUD actions for SaleRecord model.
class SaleRecordController extends Controller
{
    public $imodel;
    public $enableCsrfValidation = false;
    // 显示 其中一个订单 详情
    public function actionView($id)
    {
        $model = SaleRecord::findOne(['id' => $id]);   // 寻找 SaleRecord
        return $this->render('view', [
            'item_model' => Item::findOne(['id'=>$model->item_id]),
            'model' => $model,
        ]);
    }



    public function actionGouwu()
    {
        $sum =0;
        $test = "ok!";
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->post())
        {
          $data=Yii::$app->request->post();
          $id= $_POST["id"];

          for ($i=0; $i <=count($id)-1 ; $i++) {
             $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
             $this->redirect(Url::to(['item/view','id'=>$id[$i]]));
          }
        }

        if (Yii::$app->request->isAjax) {

            $model= Item::find()->where(['id'=>25])->one();
            return [
               'label' => $test,
               'item_name'=>$model->name,
            ];
        }

    }


    // 如果产品ID没有在于 SaleRecord 表里：创新新订单
    // 运行 购买流程
    public function actionCreate($id,$time)
    {
        $item_model = Item::findOne($id);   // 寻找 Item
        $model = new SaleRecord();
        if(empty($model->findOne(['item_id'=> $id])) || $model->find()
        ->orderBy(['id'=> SORT_DESC])
        ->where(['item_id'=> $id, 'status' => SaleRecord::STATUS_FAILED])->one())
        {
            // 创建 新订单
            $model->item_id      = $id;
            $model->order_number = Store::find()->where(['id'=>$item_model->store_id])->one()->prefix.Box::find()->where(['id'=>$item_model->box_id])->one()->code.$time;
            $model->box_id       = $item_model->box_id;
            $model->store_id     = $item_model->store_id;
            $model->sell_price   = $item_model->price;
            $model->unique_id    = $time;
            $model->store_name   = Store::find()->where(['id'=>$item_model->store_id])->one()->name;
            $model->item_name    = $item_model->name;
            $model->box_code     = Store::find()->where(['id'=>$item_model->store_id])->one()->prefix.Box::find()->where(['id'=>$item_model->box_id])->one()->code;
            $model->save();
            //创建订单时的key发送给iot；
            // Yii::$app->slack->Skey([
            // 'url'=>'https://forgetof.requestcatcher.com',
            // 'price'=>$item_model->price,
            // 'id'=>$model->id,]);
            $model->pending();


        }
        $salerecord = SaleRecord::find()->where(['item_id' => $id, 'status'=> SaleRecord::STATUS_PENDING])
        ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();

        if ($model->id == $salerecord->id)
        {
            //echo $model->order_number;
            //die();
            return $this->render('lodings',[
                'salerecord_id' => $model->order_number,
                'price' =>$item_model->price,
            ]);
            //return $this->redirect(['check','id'=>$model->id]);
        }
        else
        {
            throw new NotFoundHttpException("Requested item cannot be found.");
        }
    }


    public function actionPaycheck()
    {

        $request = \Yii::$app->request;
        $salerecord_id = $_POST['salerecord_id'];
        $price = $_POST['price'];
        $data = [
             'merchantId' => 'M100001040',
             // 'qrCode' => $barcode,
             'curType' => 'RM',
             'notifyURL' => 'https://google.com/',
             'merOrderNo' => $salerecord_id,
             'goodsName' => '',
             'detailURL' => "http://localhost:20080/sale-record/check?id=$salerecord_id",
             'orderAmt' => $price,
             'remark' => '',
             'transactionType' => '1',
             //'detailURL' =>'#',
        ];
        $data      = json_encode($data, 320);

        $response_data = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.preOrder.do', $data);
        //echo $response_data;
        //echo "one";
        if ($response_data) {
            //echo "two";
            $get_response = json_decode($response_data);
            $referenceNo  = $get_response->{'merOrderNo'};
            $token        = $get_response->{'securityData'};
            return $this->render('request',['referenceNo'=>$referenceNo,'token'=>$token,'id'=>$salerecord_id]);
        }

    }
    public function actionPays()
    {
        $request = \Yii::$app->request;//获取商品信息
        $id = $request->get('id');
        $time = $request->get('time');
        $price = $request->get('price');
        return $this->render('loding',[
            'id' => $id,
            'time' => $time,
            'price' =>$price,
        ]);
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
                return $this->render('create', [
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
                //return $this->runAction('paysuccess',['id'=>$id]);

                return $this->redirect(['paysuccess',  //error
                       'id'=>$id,
                   ]);
            }
            elseif($orderStatus == 2 || $orderStatus == 4) {
                return $this->redirect(['payfailed',
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

    public function actionCancel($id)
    {
        $model = SaleRecord::findOne(['id' => $id]);
        $model->failed();
        return $this->redirect(['store/view', 'id' => $model->store_id]);
    }

    public function actionInvoice($id)
    {
        $model = SaleRecord::findOne($id);
        $store_model = Store::findOne($model->store_id);
        $item_model = Item::findOne(['id' => $model->item_id]);

        return $this->renderPartial('receipt',[
            'model' => $model,
            'store_model' => $store_model,
            'item_model' => $item_model,
        ]);
    }

    public function actionDownload($id)
    {
        $model = SaleRecord::findOne($id);
        $store_model = Store::findOne($model->store_id);
        $item_model = Item::findOne(['id' => $model->item_id]);

        $content = $this->renderPartial('download',[
            'model' => $model,
            'store_model' => $store_model,
            'item_model' => $item_model,
        ]);

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetHeader('Vending Machine');
        $mpdf->SetFooter('<div> Page {PAGENO} of {nbpg} <br> {DATE j-m-Y}  </div>');
        $mpdf->WriteHTML($content);
        $file_name = 'invoice.pdf';
        $mpdf->Output($file_name, 'D');
        // exit;
    }


    public function actionPaysuccess($id)
    {
        $model = SaleRecord::findOne(['order_number'=>$id]);
        if ($model)
        {
            $item_model=Item::findOne(['box_id'=>$model->box_id]);
            $store_model=Store::findOne(['id'=>$model->store_id]);
            $model->success();
            return $this->render('success',[
                'model'=>$model,
                'id'=>$id,
            ]);
            //echo'success';
        }

    }
    public function actionPayfailed($id)
    {
        $model = SaleRecord::findOne(['order_number'=> $id]);;
        if ($model)
        {
            $model->failed();
            return $this->render('failed',[
                'model'=>$model,
                'id'=>$id,
            ]);
            //echo'failed';
        }
    }




}
