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

    // Lists all Item models.
    public function actionIndex()
    {
        $item_searchModel = new ItemSearch();
        $item_dataProvider = $Item_searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'item_searchModel' => $Item_searchModel,
            'item_dataProvider' => $Item_dataProvider,
        ]);
    }

    // Displays a single Item model.
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
        $item_model = new Item();
        $item_model->box_id = $id;
        $item_model->store_id = $item_model->box->store_id;
        $item_dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($item_model->box->store_id)]),
        ]);
        if ($item_model->load(Yii::$app->request->post()) && $item_model->save()) {
            return $this->redirect(['store/view', 'id' => $item_model->store_id]);
        }
        return $this->render('create', [
            'model' => $item_model,
            'item_dataProvider' => $item_dataProvider,
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
        $item_dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_DEFAULT, Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($item_model->box->store_id)]),
        ]);

        if ($item_model->load(Yii::$app->request->post()) && $item_model->save()) {
            return $this->redirect(['view', 'id' => $item_model->id]);
        }

        return $this->render('update', [
            'model' => $item_model,
            'item_dataProvider' => $item_dataProvider,
        ]);
    }

    // Deletes an existing Item model.
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
