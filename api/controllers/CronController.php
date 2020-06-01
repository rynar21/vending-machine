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

    public function actionRequest()
    {
        $records = SaleRecord::find()->where([
                'status' => SaleRecord::STATUS_PENDING,
            ])->andWhere([
                '<',
                'created_at',
                time() - 60 * 2
            ])->all();

        if ($records)
        {
            foreach ($records as $record)
            {
                $record->failed();
            }
        }

         Yii::$app->slack->Posturl([
             'url'=>'https://hooks.slack.com/services/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',
             'data'=>[
                     "vm"=>'定时任务',

                     'date'=>date('Y-m-d H:i:s', time()),
             ],
         ]);

        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }


}

























?>
