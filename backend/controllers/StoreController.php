<?php

namespace backend\controllers;

use Yii;
use common\models\Store;
use backend\models\StoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;


/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'actions' => ['index', 'view'],
            //             'allow' => Yii::$app->user->can('ac_read'),
            //         ],
            //         [
            //             'actions' => ['create','update','delete'],
            //             'allow' => true,
            //             'roles' => ['admin'],
            //         ],
            //         // [
            //         //     'actions' => ['update'],
            //         //     'allow' => true,
            //         //     'roles' => ['ac_update'],
            //         // ],
            //         // [
            //         //     'actions' => ['create'],
            //         //     'allow' => true,
            //         //     'roles' => ['ac_create'],
            //         // ],
            //         // [
            //         //     'actions' => ['delete'],
            //         //     'allow' => true,
            //         //     'roles' => ['ac_delete'],
            //         // ],
            //     ],
            // ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Store model.
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
     * Creates a new Store model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Store();
        // ActiveForm 提交后
        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Store model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        // ActiveForm 提交后
        if ($model->load(Yii::$app->request->post()))
        {
            // 保存所有数据 在于Store数据表
            if ($model->save())
            {
                // 返回 View 页面
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // 显示 Update更新页面
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Store model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
            //删除字段
            if ($model->delete()) {
                if($model->image){
                    //    删除文件
                        if (file_exists(Yii::getAlias('@upload') . '/' . $model->image)) {
                            unlink(Yii::getAlias('@upload') . '/' . $model->image);
                        }
                }
            }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Store model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Store the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
