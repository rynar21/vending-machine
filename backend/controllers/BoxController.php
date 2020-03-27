<?php

namespace backend\controllers;

use Yii;
use common\models\Box;
use backend\models\BoxSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\BaseDataProvider;
use yii\web\MethodNotAllowedHttpException;

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
                    // [
                    //     'actions' => ['index', 'view'],
                    //     'allow' => Yii::$app->user->can('ac_read'),
                    // ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ac_update'],
                    ],
                    [
                        'actions' => ['index','view'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['ac_create'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['ac_delete'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'checker' => [
               'class' => 'backend\libs\CheckerFilter',
              ],
        ];
    }

    /**
     * Lists all Box models. @return mixed
     */
    public function actionIndex()
    {
          $searchModel = new BoxSearch();
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

        if($model->store->prefix)
        {
            $model->prefix = $model->store->prefix;
        }
        else
        {
            $model->prefix = '(prefix_not_set)';
        }

        if ($model->load(Yii::$app->request->post()))
        {
            $box_model = Box::find()->where(['hardware_id'=> $model->hardware_id,'store_id'=>$model->store_id])->one();
            if ($box_model || $model->hardware_id =='00OK') {
                Yii::$app->session->setFlash('danger', 'hardware_id existed .');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            else {
                if($model->save())
                {
                    return $this->redirect(['store/view', 'id' => $model->store_id]);
                }
            }
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
        $model->code = Box::find()->where(['store_id'=> $id])->one()->code;
        if($model->store->prefix)
        {
            $model->prefix = $model->store->prefix;
        }
        else
        {
            $model->prefix = '(prefix_not_set)';
        }

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {

            $box_model = Box::find()->where(['hardware_id'=> $model->hardware_id,'store_id'=>$model->store_id])->one();
            if ($box_model || $model->hardware_id =='00OK') {
                Yii::$app->session->setFlash('danger', 'hardware ID is existed .');
                return $this->render('create', [
                    'model' => $model,
                ]);
            }
            else {
                if($model->save())
                {
                    return $this->redirect(['store/view', 'id' => $model->store_id]);
                }
            }
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
}
