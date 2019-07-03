<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\SaleRecord;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,

        ]);
    }

    public function actionIphone($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('iphone', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findModel($id),

        ]);
    }

    public function actionOk($id)
    {
        $item = Item::findOne($id);
        $model = new SaleRecord();
        $model->item_id= $id;
        $model->box_id= $id;
        $model->trans_id= $id;
        $model->save();
        // echo '<pre>';
        // print_r($model->errors);

    }
    /**
     * Display details of a single item.
     * @return mixed
     */
    public function actionPayment($id)
    {
        $model = new SaleRecord();
        // $model->item_id =$id . uniqid();
        // $model->store_description = "this is a auto generated";
        $model->save();
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('payment', [
              'searchModel' => $searchModel,
              'item_model' => $item_model,
              'model' => $this->findModel($id),
        ]);

    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionResult($id)
    {
        $model2 = new SaleRecord();
        $model2->save();
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('result', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
        ]);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
