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
            $model->item_id = $item_model->id;
            $model->box_id = $item_model->box_id;
            $model->store_id = $item_model->store_id;
            $model->sell_price = $item_model->price;
            $model->save();
            $model->pending();
        }
        $salerecord=SaleRecord::find()->where(['item_id' => $id, 'status'=> SaleRecord::STATUS_PENDING])
        ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();
        if ($model->id && $salerecord->id)
        {
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
        else
        {
            throw new NotFoundHttpException("Requested item cannot be found.");
        }
    }

    // 判断 交易订单 的状态
    public function actionCheck($id)
    {
        // $sale_model = SaleRecord::findOne($id);
        $model = SaleRecord::findOne(['id' => $id]);
        if ($model!=null)
        {
            $item_model = item::findOne(['id' => $model->item_id]);
            if ($model->status == SaleRecord::STATUS_PENDING)
            {
                $generate_signature=Yii::$app->signature->generateSignature(['data'=>$model->id.$model->sell_price]);
                return $this->render('pending', [
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

    // API Integration
    public function PayStatus($config)
    {
        $id = ArrayHelper::getValue($config, 'id','');
        $price = ArrayHelper::getValue($config, 'price','');
        $status = ArrayHelper::getValue($config, 'status','');
        $signature=ArrayHelper::getValue($config, 'signature','');
        $generate_signature=Yii::$app->signature->generateSignature(['data'=>$status]);
        if ($generate_signature==$signature)
        {
            $model = SaleRecord::findOne(['id'=>$id]);
            if ($status=='success')
            {
                $model->success();
                return  Yii::$app->slack->send([
                     'data'=>[
                         'text'=>'Store name'.':'.$model->store->name.','.
                                 'Address'.':'.$model->store->address.','.
                                 'Transaction ID'.':'.$id.','.
                                 'Purchased Time'.':'.$model->updated_at.','.
                                 'Box'.':'.$model->box->code.','.
                                 'Item'.':'.$model->item->name.','.
                                 'price'.':'.$model->item->price.','.
                                 'Payment Amount'.':'.$price,
                     ],
                 ]);
            }
            if ($status=='failed')
            {
                $model->failed();
            }
        }
        else {
            return false;
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

   //  function actionRandomStr($len=32,$special=true){
   //     $chars = array(
   //         "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k",
   //         "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v",
   //         "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G",
   //         "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R",
   //         "S", "T", "U", "V", "W", "X", "Y", "Z", "0", "1", "2",
   //         "3", "4", "5", "6", "7", "8", "9"
   //     );
   //
   //     if($special){
   //         $chars = array_merge($chars, array(
   //             "!", "@", "#", "$", "?", "|", "{", "/", ":", ";",
   //             "%", "^", "&", "*", "(", ")", "-", "_", "[", "]",
   //             "}", "<", ">", "~", "+", "=", ",", "."
   //         ));
   //     }
   //
   //     $charsLen = count($chars) - 1;
   //     shuffle($chars);                            //打乱数组顺序
   //     $str = '';
   //     for($i=0; $i<$len; $i++){
   //         $str .= $chars[mt_rand(0, $charsLen)];    //随机取出一位
   //     }
   //     echo $str;
   // }

    // public function actionHash()
    // {
    //     $id=112;
    //     $price=10;
    //     $data=$id.$price;
    //     $signature='s.OPa4c%j!F%P@8~1+D[,2Rl|%?Klmbh';
    //     // $data=sha1(md5($id.$price.$signature));
    //     $generate_signature=hash_hmac('sha256',$data,$signature);
    //     // echo $data;
    //     echo $generate_signature;
    // }
    // public function Pay($config)
    // {
    //     // $id = ArrayHelper::getValue($config, 'id','');
    //     // $price = ArrayHelper::getValue($config, 'price','');
    //     // $id=108;
    //     // $price=17;
    //     $str = ArrayHelper::getValue($config, 'str','');
    //     $signature='s.OPa4c%j!F%P@8~1+D[,2Rl|%?Klmbh';
    //     $generate_signature=sha1($id.$price.$signature);
    //     if ($str==$generate_signature) {
    //         return $this->PayStatus([
    //             'id'=>$id,
    //             'price'=>$price,
    //             'status'=>'success',
    //         ]);
    //     }
    //     if ($str!==$generate_signature) {
    //         return $this->PayStatus([
    //             'id'=>$id,
    //             'status'=>'failed',
    //         ]);
    //     }
    // }
}
