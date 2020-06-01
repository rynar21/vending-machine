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
        // Slack::postUrl([
        //     'url'=>'https://hooks.slack.com/services/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',
        //     'data'=>[
        //            "stoe_name"=>'one',
        //             "item_name"=>'col',
        //              "price"=>'12RM',
        //     ],
        // ]);
        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }
}

























?>
