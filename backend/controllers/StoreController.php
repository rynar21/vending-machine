<?php

namespace backend\controllers;

use Yii;
use common\models\Store;
use common\models\Box;
use common\models\User;
use backend\models\StoreSearch;
use backend\models\BoxSearch;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;
use yii\data\ActiveDataProvider;


/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $username;
    public $name;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view','kaiqi','store_detailed','manager_revoke','add_update',
                        'manager_update','user_store','lockup_box','open_box','box_item'],
                        'allow' => Yii::$app->user->can('ac_read'),
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ac_update'],
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
     * Lists all Store models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new StoreSearch();

        if (Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'admin'))
        {
            //当登录的用户权限是admin时，可以看到所有的商店
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }

        else { //当登录的用户权限不是admin时，只能看到自己管理的店
            $dataProvider = $searchModel->searchUserAllstore(Yii::$app->request->queryParams, Yii::$app->user->identity->id);

            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
        }
    }

    /**
     * Displays a single Store model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $boxsearch = new BoxSearch();
        $dataProvider = $boxsearch->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'boxSearch' => $boxsearch,
            // 'modelData'=>$modeldata,
        ]);
    }

    public function actionKaiqi($id)//打开盒子
    {
        //return $this->redirect(['view' ,'id' => '1']);
        //return $this->redirect(['view', 'id' => $id,'md'=>'1']);
        $boxsearch = new BoxSearch();
        $dataProvider = $boxsearch->search(Yii::$app->request->queryParams, $id);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider,
            'boxSearch' => $boxsearch,
            'md'    => '4564651',
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
            if ($model->save())
            {
                return $this->redirect(['view', 'id' => $model->id]);
            }
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
        $oldimage = Yii::getAlias('@upload') . '/' . $model->image;

        if ($model->delete())
        {

            if ($model->image)
            {

                if (file_exists($oldimage))
                {
                    unlink($oldimage);
                }

            }

        }

        return $this->redirect(['index']);
        // return $this->redirect(['index']);
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
        if (($model = Store::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionStore_detailed($id)
    {
        return $this->render('detailed', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionManager_revoke($id)
    {
        Store::updateAll(['user_id' => ''], ['id' => $id]);

        return $this->actionView($id);
    }
    //add/update mannager
    public function actionAdd_update($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()))
        {
            $getuser = User::find()->where(['username' => $model->username])->one();

            if($getuser)
            {
                $model->user_id = $getuser->id;

                if($model->save())
                {
                    return $this->actionView($id);
                }

            }

            if (empty($getuser))
            {
                Yii::$app->session->setFlash('error', 'Non exist username.');
            }

        }

        return $this->render('store_manager', [
        'model' => $this->findModel($id),
        ]);
    }

    public function actionLockup_box($id)  //锁盒子
    {
        Box::updateAll(['status' => Box::BOX_STATUS_LOCK], ['store_id' => $id]);
        Store::updateAll(['status' => Store::STATUS_IN_MAINTENANCE], ['id' => $id]);

        return $this->redirect(['store/view', 'id' => $id]);
    }

    public function actionOpen_box($id)  //开放盒子
    {
        Box::updateAll(['status' => Box::BOX_STATUS_NOT_AVAILABLE], ['store_id' => $id]);
        Store::updateAll(['status' => Store::STATUS_IN_OPERATION], ['id' => $id]);

        return $this->redirect(['store/view', 'id' => $id]) && Yii::$app->session->setFlash('success', "Store is published successful.");;
    }

    public function actionBox_item($box_id, $store_id)
    {
        // 获取 ItemSearch 数据表
        $searchModel = new ItemSearch();
        // 使用输入字段 进行搜索功能
        $dataProvider = $searchModel->searchBoxItem(Yii::$app->request->queryParams, $box_id, $store_id);

        // 当前 显示 index 页面 及 带入相关数据
        return $this->render('itemdata', [
            'searchModel' => $searchModel,      // ItemSearch Model
            'dataProvider' => $dataProvider,    // 搜索Item数据
        ]);
    }


}
