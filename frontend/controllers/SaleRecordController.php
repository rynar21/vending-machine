<?php

namespace frontend\controllers;

use Yii;
use mpdf;
use common\models\Store;
use common\models\Item;
use common\models\Box;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\authclient\signature\BaseMethod;
use common\iot\plugins\Encryption;
use common\iot\plugins\SarawakPay;
// require_once('D:\wamp64\www\vending-machine\iot\plugins\Encryption.php');
// require_once('D:\wamp64\www\vending-machine\iot\plugins\SarawakPay.php');
 //SaleRecordController implements the CRUD actions for SaleRecord model.
class SaleRecordController extends Controller
{
    public $imodel;
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
        //   $this->runAction('create',['id'=>$id[$i]]);
          // do your query stuff here\
                // return [
                //     'label' => $test,
                //     'price'=>$sum,
                //     'id'=>$id ,
                // ];
        }

        if (Yii::$app->request->isAjax) {

            $model= Item::find()->where(['id'=>25])->one();
            return [
               'label' => $test,
               'item_name'=>$model->name,
            ];
        }
        else {
            return 0;
        }
    }


    public function actionApax()
    {
        $test = "ok!";
        // do your query stuff here\
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if (Yii::$app->request->isAjax) {
            return [
               'label' => $test,
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
            Yii::$app->slack->Skey([
            'url'=>'https://forgetof.requestcatcher.com',
            'price'=>$item_model->price,
            'id'=>$model->id,]);
            $model->pending();


        }
        $salerecord=SaleRecord::find()->where(['item_id' => $id, 'status'=> SaleRecord::STATUS_PENDING])
        ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();

        if ($model->id == $salerecord->id)
        {
            return $this->render('lodings',[
                'salerecord_id' => $model->id,
                'price' =>$item_model->price,
            ]);
            //return $this->redirect(['check','id'=>$model->id]);
        }
        else
        {
            throw new NotFoundHttpException("Requested item cannot be found.");
        }
    }
    public $enableCsrfValidation = false;
    //模拟支付
    //$salerecord_id,$price,$key
    public function actionIot()
    {

        $request = \Yii::$app->request;//获取商品信息
        $salerecord_id = $_POST['salerecord_id'];
        $price = $_POST['price'];
        $key_old =$_POST['key_old'];
        $a="sha256";
        $key=100;
        $newkey = hash_hmac($a,$price.$salerecord_id.SaleRecord::KEY_SIGNATURE,$key[$raw_output=FALSE]);
        if ($newkey==$key_old) {
         return $this->redirect(['paysuccess',
                'id'=>$salerecord_id,
                //'priceiot'=>$price //金额
            ]);
        }
        else {
            return $this->redirect(['payfailed',
                   'id'=>$salerecord_id,
               ]);
        }
    }

    public function actionRequest()
    {

    }

    public function actionPaycheck()
    {

        $request = \Yii::$app->request;
        $salerecord_id = $_POST['salerecord_id'];
        //$barcode = $_POST['barcode'];
        $price = $_POST['price'];
        //echo $barcode;
        //die();
        $data = [
             'merchantId' => 'M100001040',
             // 'qrCode' => $barcode,
             'curType' => 'RM',
             'notifyURL' => 'https://google.com/',
             'merOrderNo' => $salerecord_id,
             'goodsName' => '',
             'detailURL' => 'https://h5pay.requestcatcher.com/',
             'orderAmt' => $price,
             'remark' => '',
             'transactionType' => '1',
             //'detailURL' =>'#',
        ];
        $data      = json_encode($data, 320);

        $response_data = SarawakPay::post('https://spfintech.sains.com.my/xservice/H5PaymentAction.preOrder.do', $data);
        //echo $response_data;
        $get_response = json_decode($response_data);
        $referenceNo  = $get_response->{'merOrderNo'};
        $token        = $get_response->{'securityData'};
        return $this->render('request',['referenceNo'=>$referenceNo,'token'=>$token]);
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
        $model = SaleRecord::find()->where(['id' => $id])->one();
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
                return $this->redirect(['paysuccess',
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

    public function actionKomn()
    {
        box::updateAll(['status'=>2],['store_id'=>1]);
    }

    // API Integration
    public function PayStatus($config)
    {
        $model = SaleRecord::findOne(['id'=>$id]);
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
        $model = SaleRecord::findOne(['id'=> $id]);;
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

//检查状态

    public  function actionInspection()
    {

        $models = SaleRecord::find()->where([
            'status' => 10,
        ])
        ->andWhere(['between', 'created_at' , strtotime(date('Y-m-d',strtotime('-2 day')))  ,strtotime(date('Y-m-d',strtotime('-1 day'))) ])
        ->count();
        print_r($models);
        die();
                if ($models) {
                    foreach ($models as $model) {
                            $model->failed();
                            echo $model->id . "\n";
                    }
              }

     }



    public  function actionPricesum()
    {
        $total = 0;
        $models = SaleRecord::find()->where(['status' => 10])
        // ->andWhere(['between', 'created_at' , strtotime(-$day. 'days')  ,strtotime(1-$day .'days') ])
        ->all();
                if ($models) {
                    foreach ($models as $model) {
                            $model1 = Item::find()->where(['id'=>$model->item_id])->all();
                            if ($model1) {
                                foreach ($model1 as $itemmodel ) {
                                $arr= $itemmodel->price ;
                                $total += $arr;
                                }
                            }
                    }
                    print_r($arr);

                    die();
                    $i =  array($total );
                    echo array_sum($i) . "\n";
              }
     }

     public function actionRemind()
     {
         $model_store = Store::find()->all();
         $model_box   = Box::find()->where(['status'=>Box::BOX_STATUS_AVAILABLE,'store_id'=>1])->count();
         $model_boxr  = Box::find()->where(['store_id'=>1])->count();
         echo count($model_store);
        // echo $model_boxr;
         if ($model_box>=$model_boxr*0.8) {
             echo "1";
         }
     }

}
