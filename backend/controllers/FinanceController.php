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
        return $this->render('ces');
    }
    public function actionExport_order($date)
    {
        $str= $date;
        $arr = explode('/',$str);
        $datas = Finance::get_store_salerecord(['date1'=>$arr[0],'date2'=>$arr[1]]);
        $fields = ['Date','Order ID','Box Code','Store Name','Sale Price','Cost','Order Time','Payment Time'];
        foreach ( $datas as  $data) {
            $model[] = array($data['date'],$data['order_number'],$data['box_code'],$data['store_name'],
            $data['sell_price'],$data['cost'],$data['creation_time'],$data['end_time']);
        }

        $this->export_csv($model,$fields);
    }
    public function actionExport_order_onestore($date,$store_id)
    {
        $str= $date;
        $arr = explode('/',$str);
        $datas = Finance::get_store_salerecord(['date1'=>$arr[0],'date2'=>$arr[1],'store_id'=>$store_id]);
        $fields = ['Date','Order ID','Box Code','Store Name','Sale Price','Cost','Order Time','Payment Time'];
        foreach ( $datas as  $data) {
            $model[] = array($data['date'],$data['order_number'],$data['box_code'],$data['store_name'],
            $data['sell_price'],$data['cost'],$data['creation_time'],$data['end_time']);
        }

        $this->export_csv($model,$fields);
    }

    public function actionExport_data($date)
    {
        // $date = ArrayHelper::getValue($array,'date',Null);
        // $store_id = ArrayHelper::getValue($array,'store_id',Null);
        $str= $date;
        $arr = explode('/',$str);
        $data = $this->store_finances(['date1'=>$arr[0],'date2'=>$arr[1]])[1];
        $fields = ['Date','Quantity Of Order','Total Earn','Gross Profit','Net Profit'];
        foreach ($data as  $data) {
            $model[] = array(date("d-m-Y", $data['date']),$data['quantity_of_order'],$data['total_earn'],$data['gross_profit'],$data['net_profit']);
        }

        $this->export_csv($model,$fields);
    }

    public function actionExport_data_one_store($date,$store_id)
    {
         $str= $date;
         $arr = explode('/',$str);
         $data = $this->store_finances(['date1'=>$arr[0],'date2'=>$arr[1],'store_id'=>$store_id])[1];
         $fields = ['Date','Store name','Quantity Of Order','Total Earn','Gross Profit','Net Profit'];
         foreach ($data as  $data) {
             $model[] = array(date("d-m-Y", $data['date']),$data['store_name'],
             $data['quantity_of_order'],$data['total_earn'],$data['gross_profit'],$data['net_profit']);
         }
         $this->export_csv($model,$fields);
    }

    public function export_csv($data,$fields)
    {
        $filename=time();
        //直接输出到浏览器
        //ob_end_flush();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');
        $fp=fopen('php://output', 'a');
        $flush_count=0;//刷新输出buffer计数器
        $flush_limit=500;//刷新间隔
        //写入头部标题
        $csv_header=[];
        for($i=0;$i<count($fields);$i++){
            array_push($csv_header,mb_convert_encoding($fields[$i],'gb2312','utf-8'));//注意编码问题，若使用icovn部分转码失败直接返回空
        }
        fputcsv($fp, $csv_header);
        $all=count($data);
        for ($i=0;$i<$all;$i++){//数据库取数据情况下，逐行取出数据，不浪费内存
            $flush_count++;
            if ($flush_limit==$flush_count){
                ob_flush();
                flush();
                $flush_count=0;
            }
            $row=$data[$i];
            for ($k=0;$k<count($row);$k++){
                $row[$k]=mb_convert_encoding($row[$k],'gb2312','utf-8');
            }
            fputcsv($fp, $row);
        }
        fclose($fp);

    }


    //当天所有店的详细记录
    public function actionStore_all($date)
    {
        $searchModel = new StoreFinanceSearch();

        //$models = $this->store_finance($date);
        $model = $searchModel->storeAllfinancesearch(Yii::$app->request->queryParams, $date);
        // 如果有记录
        if (!empty($model)) {
           return $this->render('store_all', [
               'searchModel' => $searchModel,
               'dataProvider'=> $model,
           ]);
        }
        //如果当天没有记录
        else {
            //Yii::$app->session->setFlash('danger', 'Sorry  no record.');
            $dataProvider = new ArrayDataProvider([
               'allModels' => array(),
           ]);
           return $this->render('store_all', [
               'dataProvider'=>$dataProvider,
           ]);
        }

    }

    public function store_finance($date)       //写入日期查询当天所有卖过商品的店
    {
        $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
        ->andWhere(['between','created_at' ,$date,$date+86399])->all();
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

    public $enableCsrfValidation = false;
    public function actionDatecheck($date1,$date2)//根据时间段查询所有商店的销售情况
    {

        $searchModel = new FinanceSearch();
        $dataProvider = $searchModel->searchDate(Yii::$app->request->queryParams,$date1,$date2);
        if ($date1<=$date2) {
            $model = $this->store_finances(['date1'=>$date1,'date2'=>$date2])[0];
            $model_date = $this->store_finances(['date1'=>$date1,'date2'=>$date2])[1];
            $dataProvider_date = new ArrayDataProvider([
               'allModels' =>$model_date,
           ]);
            // 如果有记录
            if ($model) {
                $dataProvider_all = new ArrayDataProvider([
                   'allModels' =>$model,
               ]);

               return $this->render('ces', [
                   'searchModel' => $searchModel,
                   'dataProvider_date' => $dataProvider_date,
                   'dataProvider_all'=> $dataProvider_all,
                   'start_time' => $date1,
                   'end_time' =>$date2,
               ]);
            }
            //如果当天没有记录
            if (empty($model)) {
                //Yii::$app->session->setFlash('danger', 'Sorry  no record.');
                return $this->render('ces', [
                    'searchModel' => $searchModel,
                    'dataProvider_date' => $dataProvider_date,
                    'dataProvider_all'=> array(),
                ]);
            }
        }

    }


    public function actionDatecheck_store($date1,$date2,$store_id) //根据时间段查询当前商店所有销售情况
    {
        $searchModel = new FinanceSearch();
        $dataProvider = $searchModel->searchDate(Yii::$app->request->queryParams,$date1,$date2);
        if ($date1<=$date2) {
            $model = $this->store_finances(['date1'=>$date1,'date2'=>$date2,'store_id'=>$store_id])[0];
            $model_date = $this->store_finances(['date1'=>$date1,'date2'=>$date2,'store_id'=>$store_id])[1];
            $dataProvider_date = new ArrayDataProvider([
               'allModels' =>$model_date,
           ]);
            // 如果有记录
            if ($model) {
                $dataProvider_all = new ArrayDataProvider([
                   'allModels' =>$model,
               ]);

               return $this->render('store_one_finance', [
                   'searchModel' => $searchModel,
                   'dataProvider_date' => $dataProvider_date,
                   'dataProvider_all'=> $dataProvider_all,
                   'store_id' => $store_id,
               ]);
            }
            //如果当天没有记录
            if (empty($model)) {
                //Yii::$app->session->setFlash('danger', 'Sorry  no record.');
                return $this->render('store_one_finance', [
                    'searchModel' => $searchModel,
                    'dataProvider_date' => $dataProvider_date,
                    'dataProvider_all'=> array(),
                    'store_id' => $store_id,
                ]);
            }
        }

    }

    public function store_finances($array)//date
    {
        $date1 = ArrayHelper::getValue($array,'date1',Null);
        $date2 = ArrayHelper::getValue($array,'date2',Null);
        $store_id = ArrayHelper::getValue($array,'store_id',Null);
        $catime1 = strtotime($date1);
        $catime2 = strtotime($date2);
        $total_earn = 0;
        $net_profit = 0;
        if (!empty($store_id)) {
            $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
            ->andWhere(['between','created_at' ,$catime1,$catime2+86399])
            ->andWhere(['store_id'=>$store_id])
            ->all();
            if ($models) {
                foreach ($models as $salerecord_model) {
                    $total_earn += $salerecord_model->sell_price;
                    $net_profit += $salerecord_model->sell_price - product::find()->where(['id'=>$salerecord_model->item->product_id])->one()->cost;
                }
                $store_all_data[] =  array('date'=>$date1."/".$date2,
                'quantity_of_order'=> count($models),
                'total_earn' =>$total_earn ,
                 'gross_profit' => $total_earn,
                 'net_profit'=>$net_profit,
                'store_id'=>$store_id,);
            }
            for ($i = 1; $i <=(strtotime($date2)-strtotime($date1)+86400)/86400 ; $i++) {
                $date = $catime1+86400*($i)-86400;
                $all_date[]=array('date'=>$date,'store_id'=>$store_id,
                'store_name'=> Finance::find_store_one_finance_oneday($store_id,$date)['store_name'],
                'quantity_of_order'=>Finance::find_store_one_finance_oneday($store_id,$date)['quantity_of_order'],
                'total_earn'=>Finance::find_store_one_finance_oneday($store_id,$date)['total_earn'],
                'gross_profit'=>Finance::find_store_one_finance_oneday($store_id,$date)['total_earn'],
                'net_profit'=>Finance::find_store_one_finance_oneday($store_id,$date)['net_profit'],);
            }
        }
        if (empty($store_id)) {
            $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
            ->andWhere(['between','created_at' ,$catime1,$catime2+86399])
            ->all();
            if ($models) {
                foreach ($models as $salerecord_model) {
                    $total_earn += $salerecord_model->sell_price;
                    $net_profit += $salerecord_model->sell_price - Product::find()->where(['id'=>$salerecord_model->item->product_id])->one()->cost;
                }
                $store_all_data[] =  array('date'=>$date1."/".$date2,
                'quantity_of_order'=> count($models),
                'total_earn' =>$total_earn ,
                 'gross_profit' => $total_earn,
                 'net_profit'=>$net_profit);
            }
            for ($i = 1; $i <=(strtotime($date2)-strtotime($date1)+86400)/86400 ; $i++) {
                $date = $catime1+86400*($i)-86400;
                $all_date[]=array('date'=>$date,
                'quantity_of_order'=>Finance::find_store_all_finance_oneday($date)['quantity_of_order'],
                'total_earn'=>Finance::find_store_all_finance_oneday($date)['total_earn'],
                'gross_profit'=>Finance::find_store_all_finance_oneday($date)['gross_profit'],
                'net_profit'=>Finance::find_store_all_finance_oneday($date)['net_profit'],
                );
            }
        }
        if (!empty($store_all_data)) {
            return array($store_all_data,$all_date);
        }
        if (empty($store_all_data)) {
            return array(array(),$all_date);
        }

    }

    public function store_all_finance($date1,$date2)//date
    {

        $catime1 = strtotime($date1);
        $catime2 = strtotime($date2);
        $total_earn = 0;
        $net_profit = 0;
        $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
        ->andWhere(['between','created_at' ,$catime1,$catime2+86399])
        ->all();
        if ($models) {
            foreach ($models as $salerecord_model) {
                $total_earn += $salerecord_model->sell_price;
                $net_profit += $salerecord_model->sell_price - product::find()->where(['id'=>$salerecord_model->item->product_id])->one()->cost;
            }
            $store_all_data[] =  array('date'=>$date1."/".$date2,
            'quantity_of_order'=> count($models),
            'total_earn' =>$total_earn ,
             'gross_profit' => $total_earn,
             'net_profit'=>$net_profit);
        }
        for ($i = 1; $i <=(strtotime($date2)-strtotime($date1)+86400)/86400 ; $i++) {
            $date = $catime1+86400*($i)-86400;
            $all_date[]=array('date'=>$date,
            'quantity_of_order'=>Finance::find_store_all_finance_oneday($date)['quantity_of_order'],
            'total_earn'=>Finance::find_store_all_finance_oneday($date)['total_earn'],
            'gross_profit'=>Finance::find_store_all_finance_oneday($date)['gross_profit'],
            'net_profit'=>Finance::find_store_all_finance_oneday($date)['net_profit'],
            );
        }
        if (!empty($store_all_data)) {
            return array($store_all_data,$all_date);
        }
        if (empty($store_all_data)) {
            return array(array(),$all_date);
        }
    }
}
