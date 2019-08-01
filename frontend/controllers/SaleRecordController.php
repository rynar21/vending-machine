<?php

namespace frontend\controllers;

use Yii;
use common\models\Box;
use common\models\Item;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleRecordController implements the CRUD actions for SaleRecord model.
 */
class SaleRecordController extends Controller
{

    /**
     * Displays a single SaleRecord model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = SaleRecord::findOne(['item_id' => $id]);
        return $this->render('view', [
            'item_model' => Item::findOne($id),
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SaleRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $item_model = Item::findOne($id);
        $model = new SaleRecord();
        if(empty(SaleRecord::findOne(['item_id' => $id])))
        {
            $model->item_id = $id;
            $model->box_id = $item_model->box_id;
            $model->store_id = $item_model->store_id;
            $model->status = $model::STATUS_PENDING;
            $model->save();
        }

        return $this->render('update', [
            'model' => $item_model,
            'id' => $id,
        ]);
    }

    public function actionCheck($id)
    {
        if ($model = SaleRecord::findOne(['item_id' => $id]))
        {
            switch($model->status)
            {
                case $model::STATUS_PENDING:
                $item_model = Item::findOne($id);
                $item_model->status = Item::STATUS_LOCKED;
                $item_model->save();
                return $this->render('pending', [
                    'model' => $model,
                ]);
                break;

                case $model::STATUS_SUCCESS:
                $item_model = Item::findOne($id);
                $item_model->status = Item::STATUS_SOLD;
                $item_model->save();
                $box_model = Box::findOne(['id' => $model->box_id]);
                $box_model->status = Box::BOX_STATUS_AVAILABLE;
                $box_model->save();
                //SaleRecord::model()->success();
                return $this->render('success', [
                    'model' => $model,
                ]);
                break;

                case $model::STATUS_FAILED:
                $item_model = Item::findOne($id);
                $item_model->status = Item::STATUS_AVAILABLE;
                $item_model->save();
                return $this->render('failed', [
                    'model' => $model,
                ]);
                break;

                default:
                throw new NotFoundHttpException('Undefined model status.');
                break;
            }
        }
        else {
            throw new NotFoundHttpException('The requested model does not exist.');
        }
    }
}
