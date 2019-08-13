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
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($model->load(Yii::$app->request->post()))
        {
            $model->imageFile = UploadedFile::getInstance($model, 'image');
<<<<<<< Updated upstream
            // echo "<pre>";
            // print_r($model);
            // die('here');
            if ($model->imageFile)
            {
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
                // $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                // $model->imageFile->saveAs($path, $deleteTempFile=true);
                //$model->image = 'hello'; //$model->imageFile->baseName . '.' . $model->imageFile->extension;
=======

            if ($model->imageFile)
            {
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
>>>>>>> Stashed changes
            }

            if ($model->save())
            {
<<<<<<< Updated upstream
                //$model->upload_image;
=======
                //$model->imageFile->upload;
>>>>>>> Stashed changes
                $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs($path, true);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);

    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {

        $model = Product::findOne($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->imageFile = UploadedFile::getInstance($model, 'image');

            if ($model->imageFile)
            {
                $model->image = $model->imageFile->baseName . '.' . $model->imageFile->extension;
            }

            if ($model->save())
            {
                // $model->upload_image;
                $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                $model->imageFile->saveAs($path, true);

                return $this->redirect(['view', 'id' => $model->id]);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

     //    if ($model->load(Yii::$app->request->post())){
     //     //represent the uploaded file as an instance
     //     $model->image = UploadedFile::getInstance($model, 'image');
     //     if ($model->upload()) {
     //         $model->save();
     //     }
     //     //save path to image in db
     //     // if($model->image){
     //     // $model->image = '/uploads/' . $model->image->baseName . '.' . $model->image->extension;
     //     // }
     //     //save changes in db
     //     //upload image on server
     //     Yii::$app->session->setFlash('success',"Product is successfully updated!");
     //         return $this->redirect(['view', 'id' => $model->id]);
     //     }
     //     else {
     //         return $this->render('update', [
     //             'model' => $model,
     //         ]);
     //     }
     // }


    /**
     * Deletes an existing Product model.
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

    public function actions() {
        return [
            'upload_more'=>[
                'class' => 'common\widgets'
            ]
        ];
    }
}
