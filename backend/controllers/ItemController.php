<?php
namespace backend\controllers;

use Yii;
use common\models\Item;
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
        $Item_searchModel = new ItemSearch();
        $Item_dataProvider = $Item_searchModel->search(Yii::$app->request->queryParams);
        $Record_dataProvider = new ActiveDataProvider([
            'query' => SaleRecord::find(),
        ]);

        return $this->render('index', [
            'searchModel' => $Item_searchModel,
            'dataProvider' => $Item_dataProvider,
            'dataProvider2' => $Record_dataProvider,
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
            'model' => $this->findItemModel($id),
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
        $model->box_id = $id;
        $model->store_id = $model->box->store->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['store/view', 'id' => $model->store_id]);
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
        $item_model = $this->findItemModel($id);
        $model = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($item_model->box->store_id)]),
        ]);

        if ($item_model->load(Yii::$app->request->post()) && $item_model->save()) {
            return $this->redirect(['view', 'id' => $item_model->id]);
        }

        return $this->render('update', [
            'model2' => $model,
            'model' => $item_model,
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
    protected function findItemModel($id)
    {
        if (($item_model = Item::findOne($id)) !== null) {
            return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
