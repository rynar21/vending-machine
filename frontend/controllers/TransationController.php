<?php
namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Box;
use common\models\Item;
use common\models\SaleRecord;
use backend\models\BoxSearch;
use backend\models\ItemSearch;
use backend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class TransactionController extends Controller
{

    public function actionCreate($id)
    {
        $item = Item::findOne($id);

        if ($item->status == Item::STATUS_ACTIVE) {
            $sale_records = $item->sale_records;
            foreach ($sale_records as $sale_record) {
                if ($sale_record->status == SaleRecord::STATUS_PENDING || $sale_record->status == SaleRecord::STATUS_SUCCESS) {
                    return $this->redirect(['error']);
                }
            }

            $record = new SaleRecord();
            //...
            return $this->render('success');
        }

        return $this->redirect(['error']);
    }

}
