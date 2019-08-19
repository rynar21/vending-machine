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
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;


// BoxController implements the CRUD actions for Box model.
class BoxController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => Yii::$app->user->can('ac_read'),
                    ],
                    [
                        'actions' => ['create','update','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                    // [
                    //     'actions' => ['update'],
                    //     'allow' => true,
                    //     'roles' => ['ac_update'],
                    // ],
                    // [
                    //     'actions' => ['create'],
                    //     'allow' => true,
                    //     'roles' => ['ac_create'],
                    // ],
                    // [
                    //     'actions' => ['delete'],
                    //     'allow' => true,
                    //     'roles' => ['ac_delete'],
                    // ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Box models. @return mixed
     */
    public function actionIndex()
    {
          $searchModel = new BoxSearch();
          //$searchModel->store_id = $id;
          $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
          return $this->render('index', [
              'searchModel' => $searchModel,
              'dataProvider' => $dataProvider,
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
    public function actionCreate($id)
    {
        $model = new Box();
        $model->store_id = $id;
        $model->code = (Box::find()->where(['store_id'=> $id])->count())+1;

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionSave($id)
    {
        $model = new Box();
        $model->store_id = $id;
        $model->code = (Box::find()->where(['store_id'=> $id])->count())+1;
        if ($model->save())
        {
           return $this->redirect(['store/view', 'id' => $model->store_id]);
        }
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

    // public function actionList($id){
    //   $searchModel = new BoxSearch();
    //   $searchModel->store_id = $model->id;
    //   $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    //   return $this->render('_list', [
    //       'model' => $model,
    //   ]);
    // }


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


    // public function actionList()
    // {
    //     $model = new BoxSearch();
    //     $model->store_id = $id;
    //     $box_dataProvider = $model->search(Yii::$app->request->queryParams);
    //
    //     return $this->render('_list', [
    //         // 'model' => $this->findStoreModel($id),
    //         'box_dataProvider' => $box_dataProvider,
    //     ]);
    // }


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

    protected function findStoreModel($id)
    {
        if (($store_model = Store::findOne($id)) !== null) {
            return $store_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findItemModel($id)
    {
      if (($item_model = Item::findOne($id)) !== null) {
        return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
