<?php

namespace console\controllers;
use common\models\SaleRecord;
use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }

    // 检查状态
    public function actionInspection()
    {
            $models = SaleRecord::find()->where([
                'and',
                'status' => 9,
            ['<', 'created_at', time()-900],
            ])->all();
                if ($models) {
                    foreach ($models as $model) {
                         if (time()-$model->created_at>=1) {
                            $model->failed();
                            echo "failure";
                         }
                    }
              }

     }

}
?>
