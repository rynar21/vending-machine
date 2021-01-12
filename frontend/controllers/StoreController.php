<?php

namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Item;
use backend\models\ItemSearch;
use common\models\SaleRecord;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\helpers\Json;
/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{
    public $layout = 'main_mobile';


    public function actionView($id)
    {
        $item_searchModel = new ItemSearch();
        $data = $item_searchModel->searchAvailableItem(Yii::$app->request->queryParams, $id);

        $model = $this->findModel($id);

        $articles = $data->query->all();

        if ($model->status == $model::STATUS_IN_OPERATION)
        {
            return $this->render('view', [
                'model' => $model ,
                'id' => $id,
                'item_searchModel' => $item_searchModel,
                'item_dataProvider' => $articles,
            ]);
        }
        else
        {
            return $this->render('maintain');
        }

    }


    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

   

}
