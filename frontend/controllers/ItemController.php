<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;
use common\models\SaleRecord;
use yii\web\NotFoundHttpException;
//ItemController implements the CRUD actions for Item model.
class ItemController extends Controller
{
    public $layout = 'main_mobile';

    // public function actionView($id)
    // {
    //     $model = Item::findOne(['id'=>$id]);

    //     if($model && $model->status != Item::STATUS_SOLD)
    //     {
    //         return $this->render('view', [
    //             'model' => $model,
    //         ]);
    //     }

    //     if( $model->status == Item::STATUS_SOLD)
    //     {
    //         return $this->redirect(['store/view',
    //             'id' => $model->store_id,
    //         ]);
    //     }

    //     throw new NotFoundHttpException("Requested item cannot be found.");


    // }


}
