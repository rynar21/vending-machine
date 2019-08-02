<?php

namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Box;
use common\models\Item;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{

    /**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
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
