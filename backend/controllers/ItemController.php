<?php
namespace backend\controllers;

use Yii;
use common\models\Item;
use common\models\Product;
use backend\models\ItemSearch;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

// ItemController implements the CRUD actions for Item model.
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
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // Displays a single Item model.
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Item::findOne($id),
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
        $model->store_id = $model->box->store_id;

        $dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($model->box->store_id)]),
        ]);

        $product_model = new Product();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->price = $model->product->price;
            if($model->save())
            {
                return $this->redirect(['store/view', 'id' => $model->store_id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
            'dataProvider' => $dataProvider,
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
        $model = Item::findOne($id);
        $model->box_id = $id;
        $model->store_id = $model->box->store_id;

        $dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($model->box->store_id)]),
        ]);

        $product_model = new Product();

        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->price <= 0)
            {
                $model->price = $model->product->price;
            }
            if($model->save())
            {
                return $this->redirect(['store/view', 'id' => $model->store_id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
            'dataProvider' => $dataProvider,
        ]);
    }

    // Deletes an existing Item model.
    public function actionDelete($id)
    {
        Item::findOne($id)->delete();
        return $this->redirect(['index']);
    }

}
