<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }


    // 检查支付状态
    public  function actionInspection()
    {

        $records = SaleRecord::find()->where([
                'status' => SaleRecord::STATUS_PENDING,
            ])->andWhere([
                '<',
                'created_at',
                time()-1
            ])->all();

            if ($records)
            {
                foreach ($records as $record)
                {
                        $record->failed();
                        echo $record->id . "\n";
                }
            }

     }

}
?>
