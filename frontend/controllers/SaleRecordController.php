<?php

namespace frontend\controllers;

use Yii;
use mpdf;
use common\models\Store;
use common\models\Box;
use common\models\Item;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\ActiveDataProvider;
use yii\db\Expression;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\authclient\signature\BaseMethod;

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



    public function actionCart()
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

    public function actionGet_product_information()
    {
        $request = \Yii::$app->request;//获取商品信息
        $id = $request->get('id');
        $time = $request->get('time');
        $price = $request->get('price');
        return $this->render('loading',[
            'id' => $id,
            'time' => $time,
            'price' =>$price,
        ]);
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
            return $this->render('loadings',[
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
        }
    }


}
