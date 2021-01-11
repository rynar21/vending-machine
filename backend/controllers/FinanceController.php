<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use backend\models\SaleRecordSearch;
use yii\web;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


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
                    'class' => AccessControl::class,
                'rules' =>
                [
                    [
                        'actions' => ['index', 'view', 'export'],
                        'allow' => true,
                        'roles' => ['allowReport'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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
        $searchModel = new SaleRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $total_amount = $dataProvider->query->sum('sell_price');
        $total_transaction = $dataProvider->getTotalCount();
        $actual_amount = $searchModel->actualAmount();

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total_amount' => $total_amount,
            'total_transaction' => $total_transaction,
            'actual_amount' => $actual_amount,
        ]);
    }
   
    public function actionExport($time_start=null, $time_end=null, $store_id=null, $status=null ,$item_id=null)
    {
        //PmsLog::push(Yii::$app->user->identity->id,'report','export_payment');

        $searchModel = new SaleRecordSearch();
        $searchModel->time_start = $time_start;
        $searchModel->time_end = $time_end;
        $searchModel->store_id = $store_id;
        $searchModel->status = $status;
        $searchModel->item_id = $item_id;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $filename = "report_payment_". date("d/M/Y", time());
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        
        header('Cache-Control: max-age=0');
        $fp = fopen('php://output', 'a');
        fputcsv($fp, [
            'Order Number',
            'Store',
            'Item',
            'Sell Price',
            'Payment Time',
        ]);

        $dataProvider->pagination = false;    

        foreach ($dataProvider->getModels() as $model) {
            fputcsv($fp, [
                $model->order_number,
                $model->store->name,
                $model->item->name,
                $model->sell_price,
                Yii::$app->formatter->asDateTime($model->created_at),
            ]);
        }
        fclose($fp);

        exit();
    }

}
