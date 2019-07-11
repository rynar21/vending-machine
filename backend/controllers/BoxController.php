<?php

namespace backend\controllers;

use Yii;
use common\models\Box;
use common\models\Store;
use common\models\Item;
use backend\models\BoxSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

/**
 * BoxController implements the CRUD actions for Box model.
 */
class BoxController extends Controller
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
     * Lists all Box models.
     * @return mixed
     */
    public function actionIndex2()
    {
        $searchModel2 = new BoxSearch();
        $dataProvider2 = $searchModel2->search(Yii::$app->request->queryParams);

        return $this->render('index2', [
            'searchModel2' => $searchModel2,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    // public function actionBox()
    // {
    //     $searchModel = new BoxSearch();
    //     $dataProvider2 =new ActiveDataProvider([
    //
    //       'query' => box::find(),
    //     ])
    //
    //     return $this->render('index', [
    //
    //         'dataProvider2' => $dataProvider2,
    //     ]);
    // }


    public function actionIndex($id)
    {
      $searchModel = new BoxSearch();
      $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
      $store_model = new ActiveDataProvider(['query'=> store::find(),]);
      $item_model = new ActiveDataProvider(['query' => Item::find(),]);

      return $this->render('index', [
          'searchModel' => $searchModel,
          'dataProvider' => $dataProvider,
          'store_model' => $this->findModel3($id),
          'item_model' => $item_model,
      ]);
    }

    /**
     * Displays a single Box model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new Box model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Box();

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Box model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Box model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Box model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Box the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Box::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel3($id)
    {
        if (($model3 = Store::findOne($id)) !== null) {
            return $model3;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel5($id)
    {
      if (($model5 = Item::findOne($id)) !== null) {
        return $model5;
    }
    throw new NotFoundHttpException('The requested page does not exist.');
    }
}
