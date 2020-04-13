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

        if (Item::findOne(['id'=>$model->item_id]))
        {
            return $this->render('view', [
                'item_model' => Item::findOne(['id'=>$model->item_id]),
                'model' => $model,
            ]);
        }

        return false; // 寻找 SaleRecord
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

}
