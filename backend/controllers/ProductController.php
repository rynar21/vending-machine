<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
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
     * 创建新产品记录
     * 如果创建呈贡, 返回 View 页面.
     * @return mixed
     */
    public function actionCreate()
    {
        // 加载 Product 产品 数据表
        $model = new Product();

        // ActiveForm 提交后
        if ($model->load(Yii::$app->request->post()))
        {
            if ($model->imageFile==null) {

                    $model->image= 'product.jpg';

            }
            if ($model->save())
            {
                $path = Yii::getAlias('@upload') . '/' . $model->image;

                if ($path>0) {

                    $model->imageFile->saveAs($path, true);

                }
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }
        // 显示 Create创建页面
        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * 更新当前的产品
     * 如果更新成功, 返回 View页面.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if ($model->save())
            {
               return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {       $model = $this->findModel($id);

            //删除字段
            if ($model->delete()) {
                    //删除文件
                    if (file_exists(Yii::getAlias('@upload') . '/' . $model->image)) {
                        if ($model->image!='product.jpg') {
                            unlink(Yii::getAlias('@upload') . '/' . $model->image);
                        }
                    }

                }
        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
