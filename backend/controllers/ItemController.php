<?php
namespace backend\controllers;

use Yii;
use common\models\Store;
use common\models\Item;
use common\models\Box;
use common\models\SaleRecord;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

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
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider2 = new ActiveDataProvider([
            'query' => SaleRecord::find(),
        ]);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    public function actionHome()
    {
        // Create an instance of class Item
        $item_model = new Item();
        // Modify data within database
        if ($item_model->load(Yii::$app->request->post()) && $item_model->save())
        {
            return $this->redirect(['view', 'id' => $item_model->id]);
        }
        // Import data from class Item
        $item_data = new ActiveDataProvider([
            'query' => Item::find(),
        ]);
        // Import data from class SaleRecord
        $record_data = new ActiveDataProvider([
            'query' => SaleRecord::find(),
        ]);
        $box_data = new ActiveDataProvider([
            'query' => box::find(),
        ]);
        $store_data = new ActiveDataProvider([
            'query' => Store::find(),
        ]);

        // Display '@home.php' with data
        return $this->render('home', [
            'item_model' => $item_model,
            'item_data' => $item_data,
            'record_data' => $record_data,
            'store_data' => $store_data,
            'box_data' => $box_data,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new Item();
        $model->box_id =$id;
        $model->store_id=$model->box->store_id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $dataProvider2 = new ActiveDataProvider([
            'query' => box::find(),
        ]);
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider2' => $dataProvider2,
        ]);
    }

    /**
     * Deletes an existing Item model.
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
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
