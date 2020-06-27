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
use common\components\PayAndGo;
use yii\helpers\Json;
/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{

    // 显示 Store表 其中一个数据 详情
    // 采用 ItemSeearch表 来寻找 未购买成功的产品
    public function actionView($id)
    {
        $item_searchModel = new ItemSearch();
        $data = $item_searchModel->searchAvailableItem(Yii::$app->request->queryParams, $id);
        // $count = $data->query->count(); //数据总条数
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

    public function actionTry()
    {
        $model = SaleRecord::findOne(4);
        $model->executeUpdateStatus();
        // $model1 = SaleRecord::findOne(6);
        // $model1->executeUpdateStatus();
    }


}
