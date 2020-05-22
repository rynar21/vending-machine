<?php
namespace frontend\controllers;

use Yii;
use yii\data\ArrayDataProvider;
use common\models\SaleRecord;
use yii\rest\Controller;

/**
 * Site controller
 */
class InternalController extends Controller
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
        return [
            'data' => [
                'update' => 'ok',
            ]
        ];
    }
}

























?>
