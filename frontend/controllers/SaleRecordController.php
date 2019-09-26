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

    // API Integration
    public function actionPaysuccess($id)
    {
        $model = SaleRecord::findOne(['id'=>$id]);
        if ($model)
        {
            $model->success();
            echo'success';
        }
    }

    public function actionPayfailed($id)
    {
        $model = SaleRecord::findOne(['id'=> $id]);
        if ($model)
        {
            $model->failed();
            echo'failed';
        }
    }

}
