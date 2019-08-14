<?php

namespace backend\controllers;

use Yii;
use common\models\Store;
use backend\models\StoreSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
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
        if ($model->load(Yii::$app->request->post()))
        {
            //读取 Store商店数据表 Image入境
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            //如果 有图片
            if ($model->imageFile)
            {
                // 保存图片入境 在于图片属性
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }

            //如果 没有图片
            if($model->imageFile == null)
            {
                // 保存默认图片
                $model->imageUrl;
            }

            // 保存所有数据 在于Store数据表
            if ($model->save())
            {
                if($model->imageFile)
                {
                    // 保存图片入境
                    $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                    // 另保存图片 & 清除缓存
                    $model->imageFile->saveAs($path, true);
                }
                // 返回 View 页面
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        // 显示 Create创建页面
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
        $model = Store::findOne($id);

        // ActiveForm 提交后
        if ($model->load(Yii::$app->request->post()))
        {
            // 保存所有数据 在于Store数据表
            if ($model->save())
            {
                if($model->imageFile)
                {
                    // 保存图片入境
                    $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                    // 另保存图片 & 清除缓存
                    $model->imageFile->saveAs($path, true);
                }
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
        $this->findModel($id)->delete();

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
