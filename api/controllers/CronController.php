<?php
namespace api\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use common\models\SaleRecord;
use yii\rest\Controller;


/**
 * Site controller
 */
class CronController extends Controller
{

    public function actionMinute()
    {
        $this->queryPendingOrder();

        // $this->testAPI();

        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }

    private function queryPendingOrder()
    {
        $SaleRecord = new SaleRecord();
        $SaleRecord->queryPendingOrder();
    }

    

}

























?>
