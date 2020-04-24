<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use common\models\Box;
use common\models\User;
use common\models\Product;
use common\models\Store;
use common\models\Item;
use common\models\Queue;
use common\models\Finance;
use yii\helpers\ArrayHelper;
use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }


    // 检查支付状态
    public  function actionInspection()
    {

        $models = SaleRecord::find()->where([
                'status' => SaleRecord::STATUS_PENDING,
            ])->andWhere([
                '<',
                'created_at',
                time()-1
            ])->all();
            
            if ($models)
            {
                foreach ($models as $model)
                {
                        $model->failed();
                        echo $model->id . "\n";
                }
            }

     }


}
?>
