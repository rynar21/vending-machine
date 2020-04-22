<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use common\models\Finance;
use common\models\SaleRecord;
use common\models\Store;
use common\models\Item;
use common\models\Product;
use backend\models\StoreSearch;
use backend\models\FinanceSearch;
use backend\models\StoreFinanceSearch;
use yii\web;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\web\MethodNotAllowedHttpException;
use yii\helpers\ArrayHelper;

/**
 * FinanceController implements the CRUD actions for Finance model.
 */
class FinanceController extends Controller
{
    //public $enableCsrfValidation = false;
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
                        'actions' => ['index', 'view','store_all','datecheck','datecheck_store',
                        'export_data_one_store','export_data','export_order','export_order_onestore'
                            ],
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
        //$searchModel = new FinanceSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index');
    }
    public function actionExport_order($date)
    {
        $str = $date;
        $arr = explode('/', $str);
        $datas = Finance::get_salerecord([
            'date1' => $arr[0],
            'date2' => $arr[1]
        ]);

        $fields = ['Date','Order ID', 'Box Code', 'Store Name', 'Sale Price', 'Cost', 'Order Time', 'Payment Time'];

        foreach ( $datas as  $data )
        {
            $model[] = [
                $data['date'],
                $data['order_number'],
                $data['box_code'],
                $data['store_name'],
                $data['sell_price'],
                $data['cost'],
                $data['creation_time'],
                $data['end_time']
            ];
        }

        $this->export_csv($model, $fields);
    }


    public function actionExport_order_onestore($date, $store_id)
    {
        $str = $date;
        $arr = explode('/',$str);

        $datas = Finance::get_salerecord([
            'date1' => $arr[0],
            'date2' => $arr[1],
            'store_id' => $store_id
        ]);

        $fields = ['Date', 'Order ID', 'Box Code', 'Store Name', 'Sale Price', 'Cost', 'Order Time', 'Payment Time'];

        foreach ( $datas as  $data)
        {
            $model[] = [
                $data['date'],
                $data['order_number'],
                $data['box_code'],
                $data['store_name'],
                $data['sell_price'],
                $data['cost'],
                $data['creation_time'],
                $data['end_time']
            ];
        }

        $this->export_csv($model,$fields);
    }


    public function actionExport_data($date)
    {

        $str = $date;
        $arr = explode('/', $str);
        $data = Finance::get_financials([
            'date1' => $arr[0],
            'date2' => $arr[1]
        ])[1];

        $fields = ['Date', 'Quantity Of Order', 'Total Earn', 'Gross Profit', 'Net Profit'];

        foreach ($data as  $data)
        {
            $model[] = [
                date("d-m-Y", $data['date']),
                $data['quantity_of_order'],
                $data['total_earn'],
                $data['gross_profit'],
                $data['net_profit']
            ];
        }

        $this->export_csv($model,$fields);
    }

    public function actionExport_data_one_store($date, $store_id)
    {
        $str = $date;
        $arr = explode('/', $str);
        $data = Finance::get_financials([
            'date1' => $arr[0],
            'date2' => $arr[1],
            'store_id' => $store_id
        ])[1];

        $fields = ['Date', 'Store name', 'Quantity Of Order', 'Total Earn', 'Gross Profit', 'Net Profit'];

        foreach ($data as  $data)
        {
            $model[] = [
                 date("d-m-Y",
                $data['date']),
                $data['store_name'],
                $data['quantity_of_order'],
                $data['total_earn'],
                $data['gross_profit'],
                $data['net_profit']
            ];
        }

        $this->export_csv($model, $fields);
    }


    public function export_csv($data, $fields)
    {

        $filename = time();
        //直接输出到浏览器
        //ob_end_flush();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');
        $flush_count = 0;//刷新输出buffer计数器
        $flush_limit = 500;//刷新间隔
        //写入头部标题
        $csv_header = [];

        for($i = 0; $i < count($fields); $i++)
        {
            array_push($csv_header, mb_convert_encoding($fields[$i], 'gb2312','utf-8'));//注意编码问题，若使用icovn部分转码失败直接返回空
        }

        fputcsv($fp, $csv_header);
        $all = count($data);

        for ($i = 0; $i < $all; $i++)
        {//数据库取数据情况下，逐行取出数据，不浪费内存
            $flush_count++;

            if ($flush_limit == $flush_count)
            {
                ob_flush();
                flush();
                $flush_count = 0;
            }

            $row = $data[$i];

            for ($k = 0; $k < count($row); $k++)
            {
                $row[$k] = mb_convert_encoding($row[$k], 'gb2312', 'utf-8');
            }
            fputcsv($fp, $row);
        }
        fclose($fp);
        exit();

    }


    //当天所有店的详细记录
    public function actionStore_all($date)
    {
        $searchModel = new StoreFinanceSearch();

        //$models = $this->store_finance($date);
        $model = $searchModel->storeAllfinancesearch(Yii::$app->request->queryParams, $date);

        // 如果有记录
        if (!empty($model))
        {
           return $this->render('store_all', [
               'searchModel' => $searchModel,
               'dataProvider'=> $model,
           ]);
        }

        $dataProvider = new ArrayDataProvider([
           'allModels' => array(),
        ]);

        return $this->render('store_all', [
            'dataProvider' => $dataProvider,
        ]);
    }

    //本钱查询


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

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
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

        if ($model->load(Yii::$app->request->post()) && $model->save())
        {
            return $this->redirect([
                'view',
                'id' => $model->id
            ]);
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
        if (($model = Finance::findOne($id)) !== null)
        {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }




    public function actionDatecheck($date1, $date2)//根据时间段查询所有商店的销售情况
    {
        $searchModel  = new FinanceSearch();
        $dataProvider = $searchModel->searchDate(Yii::$app->request->queryParams, $date1, $date2);

        if ($date1 <= $date2)
        {
            $model      = Finance::get_financials(['queryDate_start' => $date1, 'queryDate_end' => $date2])[0];
            $model_date = Finance::get_financials(['queryDate_start' => $date1, 'queryDate_end' => $date2])[1];

            $dataProvider_date = new ArrayDataProvider([
                'allModels' => $model_date,
            ]);

            // 如果有记录
            if ($model)
            {
                $dataProvider_all = new ArrayDataProvider([
                    'allModels' => $model,
                ]);

                return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider_date' => $dataProvider_date,
                    'dataProvider_all'=> $dataProvider_all,
                    'start_time' => $date1,
                    'end_time' => $date2,
                ]);
            }

            //如果当天没有记录
            return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider_date' => $dataProvider_date,
                'dataProvider_all' => array(),
            ]);

        }

    }


    public function actionDatecheck_store($date1, $date2, $store_id) //根据时间段查询当前商店所有销售情况
    {
        $searchModel  = new FinanceSearch();
        $dataProvider = $searchModel->searchDate(Yii::$app->request->queryParams,$date1,$date2);

        if ($date1 <= $date2)
        {
            $model      = Finance::get_financials(['queryDate_start'=>$date1,'queryDate_end'=>$date2,'store_id'=>$store_id])[0];
            $model_date = Finance::get_financials(['queryDate_start'=>$date1,'queryDate_end'=>$date2,'store_id'=>$store_id])[1];

            $dataProvider_date = new ArrayDataProvider([
                'allModels' => $model_date,
            ]);

            // 如果有记录
            if ($model)
            {
                $dataProvider_all = new ArrayDataProvider([
                    'allModels' => $model,
                ]);

                return $this->render('store_one_finance', [
                    'searchModel' => $searchModel,
                    'dataProvider_date' => $dataProvider_date,
                    'dataProvider_all' => $dataProvider_all,
                    'store_id' => $store_id,
                ]);
            }

            //如果当天没有记录
            return $this->render('store_one_finance', [
                'searchModel' => $searchModel,
                'dataProvider_date' => $dataProvider_date,
                'dataProvider_all' => array(),
                'store_id' => $store_id,
            ]);

        }

    }

}
