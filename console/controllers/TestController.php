<?php

namespace console\controllers;
use common\models\SaleRecord;
use common\models\Box;
use common\models\Store;
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
        ])->andWhere(['<', 'created_at', time()-1])->all();
                if ($models) {
                    foreach ($models as $model) {
                            $model->failed();
                            echo $model->id . "\n";
                    }
              }

     }
     //检查某店的商品
     // public function actionRemind()
     // {
     //     $model_box=Box::find()->where(['status'=>Box::BOX_STATUS_AVAILABLE,'store_id'=>1])->count();
     // }
     public function actionReplace()
     {
         //$models = Product::find()->where
         if (file_exists(Yii::getAlias('C:\Users\user\Desktop\image') . '/' . $this->image))
         {
             unlink(Yii::getAlias('@upload') . '/' . $this->image);
         }
          $this->image = time(). '_' . uniqid() . '.' . $this->imageFile->extension;
     }





}
?>
