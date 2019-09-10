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
    public  function actionInspection()
    {

        $models = SaleRecord::find()->where([
            'status' => 9,
        ])->andWhere(['<', 'created_at', time()-900])->all();
                if ($models) {
                    foreach ($models as $model) {
                            $model->failed();
                            echo $model->id . "\n";
                    }
              }

     }

     


}
?>
