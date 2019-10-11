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


 //SaleRecordController implements the CRUD actions for SaleRecord model.
class SaleRecordController extends Controller
{

    // 显示 其中一个订单 详情
    public function actionView($id)
    {
        $model = SaleRecord::findOne(['id' => $id]);   // 寻找 SaleRecord
        return $this->render('view', [
            'item_model' => Item::findOne(['id'=>$model->item_id]),
            'model' => $model,
        ]);
    }

    // 如果产品ID没有在于 SaleRecord 表里：创新新订单
    // 运行 购买流程
    public function actionCreate($id)
    {
        $item_model = Item::findOne($id);   // 寻找 Item
        $model = new SaleRecord();
        //if($model->find()->where(['item_id'=> $id, 'status' != SaleRecord::STATUS_PENDING]) && $model->find()->where(['item_id'=> $id, 'status' != SaleRecord::STATUS_SUCCESS]))
        if(empty($model->findOne(['item_id'=> $id])) || $model->find()
        ->orderBy(['id'=> SORT_DESC])
        ->where(['item_id'=> $id, 'status' => SaleRecord::STATUS_FAILED])->one())
        {
            // 创建 新订单
            $model->item_id = $id;
            $model->box_id = $item_model->box_id;
            $model->store_id = $item_model->store_id;
            $model->sell_price =$item_model->price;
            $model->save();
            //创建订单时的key发送给iot；
            Yii::$app->slack->Skey([
            'url'=>'https://fy.requestcatcher.com/',
            'price'=>$item_model->price,'id'=>$model->id,]);
            $model->pending();


        }
        $salerecord=SaleRecord::find()->where(['item_id' => $id, 'status'=> SaleRecord::STATUS_PENDING])
        ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();

        if ($model->id==$salerecord->id)
        {
            //Yii::$app->slack->Skey(['price'=>1->price,'id'=>$model->id,]);
            return $this->redirect(['check','id'=>$model->created_at]);

        }
        else {
            return $this->render('update', [
                'item_model' => $item_model,
                'model' => $model,
                'id' => $id,
            ]);
        }
    }
    //模拟支付
    public function actionIot($salerecord_id,$price,$key)
    {
        $newkey=md5($price.$salerecord_id.SaleRecord::KEY_SIGNATURE);
        if ($newkey==$key) {
         return $this->redirect(['paysuccess',
                'id'=>$salerecord_id,
                'priceiot'=>$price
            ]);
            //echo "1";
        }
        else {
            echo "0";
        }

    }


    // 判断 交易订单 的状态
    public function actionCheck($id)
    {
        // $sale_model = SaleRecord::findOne($id);
        $model = SaleRecord::find()->where(['created_at' => $id])->one();
        $item_model = item::find()->where(['id' => $model->item_id])->one();
        if ($model!=null)
        {
            if ($model->status == SaleRecord::STATUS_PENDING)
            {
                return $this->render('create', [
                    'item_model' => $item_model,
                    'model' => $model,
                    'id' => $id,
                ]);
            }
            //  当SaleRecord 交易订单状态为交易成功
            elseif ($model->status== SaleRecord::STATUS_SUCCESS)
            {
                return $this->render('success', [
                    'model' => $model,
                    'id' => $id,
                ]);
            }
            //  当SaleRecord 交易订单状态为交易失败
            elseif ($model->status== SaleRecord::STATUS_FAILED)
            {
                  return $this->render('failed', [
                      'model' => $model,
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
        // $a="sha256";
        // $b='123456sa';
        // $key=1;
        // $i=hash_hmac ($a , $b , $key [$raw_output=FALSE]);
        // echo $i;
        
    }

    // API Integration
    public function actionPaysuccess($id)
    //,$priceiot)
    {

        $model = SaleRecord::findOne(['id'=>$id]);
        if ($model)
        {
            $item_model=Item::findOne(['box_id'=>$model->box_id]);
            $store_model=Store::findOne(['id'=>$model->store_id]);
            $model->success();
            Yii::$app->slack->Posturl([
                //'url'=>'https://hooks.slack.com/services/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',
                'data'=>[
                       "stoe_name"=>$store_model->name,
                        "item_id"=>$model->item_id,
                         "BOX_id"=>$model->box_id,
                         "item_name"=>$item_model->name,
                         "price"=>$item_model->price."RM",
                         //'iotprice'=>$priceiot.'RM',
                ],
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
            echo'failed';
        }
    }

    //检查状态
   public  function actionInspection()
   {

       $models = SaleRecord::find()->where([
           'status' => 9,
       ])->andWhere(['<', 'created_at', time()-1])->all();
               if ($models) {
                   foreach ($models as $model) {
                           $model->failed();
                           echo $model->id . "\n";
                   }
             }

    }

    public  function actionKip()
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
                            $model1=Item::find()->where(['id'=>$model->item_id])->all();
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
         $model_store=Store::find()->all();
         $model_box=Box::find()->where(['status'=>Box::BOX_STATUS_AVAILABLE,'store_id'=>1])->count();
         $model_boxr=Box::find()->where(['store_id'=>1])->count();
         echo count($model_store);
        // echo $model_boxr;
         if ($model_box>=$model_boxr*0.8) {
             echo "1";
         }
     }

}
