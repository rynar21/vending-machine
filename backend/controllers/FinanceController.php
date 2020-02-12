<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Finance;
use common\models\SaleRecord;
use common\models\Store;
use common\models\Item;
use common\models\product;
use backend\models\FinanceSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\MethodNotAllowedHttpException;

/**
 * FinanceController implements the CRUD actions for Finance model.
 */
class FinanceController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                    'class' => AccessControl::className(),
                'rules' =>
                [
                    [
                        'actions' => ['index', 'view','store_all'],
                        'allow' => Yii::$app->user->can('ac_product_read'),
                    ],
                    [
                        'actions' => ['update','delete'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'checker' => [
               'class' => 'backend\libs\CheckerFilter',
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
     * Lists all Finance models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    //当天所有店的详细记录
    public function actionStore_all($date)
    {

        $model = $this->store_finance($date);
        // 如果有记录
        if ($model) {
            $dataProvider = new ArrayDataProvider([
               'allModels' =>$model,
               // 'pagination' => [
               //     'pageSize' => $page,
               // ],
           ]);
           return $this->render('store_all', [
               //'searchModel' => $searchModel,
               'dataProvider'=>$dataProvider,
           ]);
        }
        //如果当天没有记录
        if (empty($model)) {
            Yii::$app->session->setFlash('danger', 'Sorry  no record.');

            return $this->redirect(Url::to(['finance/index']));
        }

    }

    public function store_finance($date)       //写入日期查询当天所有卖过商品的店
    {
        $catime = strtotime($date);
        $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
        ->andWhere(['between','created_at' ,$catime,($catime+86399)])->all();
        if ($models) {
            foreach ($models as $salerecord_model) {

                $store_all_data[] =  array('store_id' =>$salerecord_model->store_id , 'date' =>$date);
            }
            //$a = array_unique($store_id); // 维数组去重复
            $store_all_data = $this->array_unique_fb($store_all_data);
            return $store_all_data;
        }

        if (empty($store_id)) {
            return false;
        }
    }
    //二维数组去重
    function array_unique_fb($array2D){

         foreach ($array2D as $v){
          $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
          $temp[]=$v;
         }
         $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
         foreach ($temp as $k => $v){
           $temp[$k] =  array('store_id' =>explode(',',$v)[0] , 'date' => explode(',',$v)[1]); //再将拆开的数组重新组装
         }
         return $temp;

    }

    //本钱查询
    public function net_profit($id)
    {
           $p_id = Item::find()->where(['id'=>$id])->one()->product_id;
           $model = Product ::find()->where(['id'=>$p_id])->one();
           if (!empty($model->cost)) {
               $cost_price = $model->cost;
               return $cost_price;
           }
           else {
               return 0;
           }
    }

    /**
     * Displays a single Finance model.
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
     * Creates a new Finance model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Finance();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Finance model.
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

    /**
     * Deletes an existing Finance model.
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
     * Finds the Finance model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Finance the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Finance::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
