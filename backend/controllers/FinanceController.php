<?php

namespace backend\controllers;

use Yii;
use yii\helpers\Url;
use backend\models\SaleRecordSearch;
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
                        'actions' => ['index', 'view'],
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

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'total_amount' => $total_amount,
            'total_transaction' => $total_transaction
        ]);
    }
    
 

    

}
