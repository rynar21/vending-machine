<?php

namespace frontend\controllers;

use Yii;
use common\models\Store;
use backend\models\ItemSearch;
use yii\web\Controller;

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
        $item_dataProvider = $item_searchModel->searchAvailableItem(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => Store::findOne($id),
            'id' => $id,
            'item_searchModel' => $item_searchModel,
            'item_dataProvider' => $item_dataProvider,
        ]);
    }

}
