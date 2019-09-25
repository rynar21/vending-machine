<?php

namespace frontend\controllers;

use Yii;
use mpdf;
use common\models\Store;
use common\models\Item;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;


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
            $model->sell_price = $item_model->price;
            $model->save();
            $model->pending();
        }
        $salerecord=SaleRecord::find()->where(['item_id' => $id, 'status'=> SaleRecord::STATUS_PENDING])
        ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();
        if ($model->id==$salerecord->id)
        {
            return $this->redirect(['check','id'=>$model->id]);
        }
        else {
            return $this->render('update', [
                'item_model' => $item_model,
                'model' => $model,
                'id' => $id,
            ]);
        }
    }

    // 判断 交易订单 的状态
    public function actionCheck($id)
    {

        // $sale_model = SaleRecord::findOne($id);
        $model = SaleRecord::find()->where(['id' => $id])->one();
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

    //出售消息
    public function postUrl($array)
    {
            $url = ArrayHelper::getValue($array, 'url', 'https://fy.requestcatcher.com/');
            $data=ArrayHelper::getValue($array,'data','Hello World!');
            if(is_array($data))
            {
                $e=$this->eopLo($data);//键值分离，转换为字符串
                $a=["text"=>$e];
            }
            if(!is_array($data))
            {
                $a=["text"=>$data];
            }
            $data  = json_encode($a);
            $headerArray =array("Content-type:application/json;charset='utf-8'","Accept:application/json");//设置格式
            $curl = curl_init();//初始化CURL句柄
            curl_setopt($curl, CURLOPT_URL, $url);//设置请求的URL
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);//验证证书
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST,FALSE);//针对主机验证证书的名称
            curl_setopt($curl, CURLOPT_POST, 1);//如果你想PHP去做一个正规的HTTP POST，设置这个选项为一个非零值。
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);//传递一个作为HTTP “POST”操作的所有数据的字符串。
            curl_setopt($curl,CURLOPT_HTTPHEADER,$headerArray);//设置自定义HTTP标头
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//讲curl_exec()获取的信息以文件流的形式返回，而不是直接输出。
            $output = curl_exec($curl); //执行一个cURL会话
            curl_close($curl);//关闭一个cURL会话
            return json_decode($output,true);
    }

    public function actionKomn()
    {
        $this->Posturl([
           // 'url'=>'https://hooks.slack.com/services/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',
            'data'=>[
                   "stoe_name"=>'one',
                    "item_name"=>'col',
                     "price"=>'12RM',
            ],
        ]);


    }
    //一维数组键值分离......并转换为字符串
    public function eopLo($data)
    {
        $kunum =(array_keys($data));
        $sk = (array_values($data));
        for ($i=0; $i <=count($kunum)-1; $i++)
        {
            $d[]=array($kunum[$i],$sk[$i]);
        }
        foreach ($d as $val) {
        $val = join(":",$val);
        $temp_array[] = $val;
        }
        $e=implode(",",$temp_array);
        return $e;
    }

    // API Integration
    public function actionPaysuccess($id)
    {
        $model = SaleRecord::findOne(['id'=>$id]);
        $item_model=Item::findOne(['box_id'=>$model->box_id]);
        $store_model=Store::findOne(['id'=>$model->store_id]);
        if ($model)
        {
            $model->success();
            $this->Posturl([
                'url'=>'https://hooks.slack.com/services/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',
                'data'=>[
                       "stoe_name"=>$store_model->name,
                        "item_id"=>$model->item_id,
                         "BOX_id"=>$model->box_id,
                         "item_name"=>$item_model->name,
                         "price"=>$item_model->price."RM",

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

}
