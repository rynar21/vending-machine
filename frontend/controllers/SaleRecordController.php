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
        $model = SaleRecord::findOne(['id' => $id]);
        $item_model = Item::findOne(['id' => $model->item_id]);

        if ($item_model)
        {
            return $this->render('view', [
                'item_model' => $item_model,
                'model' => $model,
            ]);
        }

        return false; // 寻找 SaleRecord
    }


    public function actionInvoice($id)
    {
        $model       = SaleRecord::findOne($id);
        $store_model = Store::findOne($model->store_id);
        $item_model  = Item::findOne(['id' => $model->item_id]);

        return $this->renderPartial('receipt',[
            'model' => $model,
            'store_model' => $store_model,
            'item_model' => $item_model,
        ]);
    }


    public function actionDownload($id)
    {
        $model       = SaleRecord::findOne($id);
        $store_model = Store::findOne($model->store_id);
        $item_model  = Item::findOne(['id' => $model->item_id]);

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

    public function actionSale($order_number,$salerecord_id)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $model =  SaleRecord ::find()->where(['order_number' => $salerecord_id])->one();
        if ($model) {
            $model->unique_id = $order_number;
            $model->save();
        }
        //SaleRecord::updateAll(['unique_id' => $order_number], 'order_number' => $salerecord_id );
        //$model = SaleRecord::findOne('order_number' => $salerecord_id);

        return  [
            'id' => $order_number.'----'.$salerecord_id,
        ];

    }

}
