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
        return $this->render('view', [
            'store_id' => $id,
        ]);    
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
