<?php

namespace api\controllers;

use Yii;
use common\models\Box;
use common\models\Store;
use backend\models\BoxSearch;
use common\models\SaleRecord;
use common\models\Product;
use yii\rest\Controller;
use common\models\Queue;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

// BoxController implements the CRUD actions for Box model.
class TestController extends Controller
{
    public function actionOpenBox()
    {
        $id = Yii::$app->request->getBodyParam('id');
        $hardware_id = Yii::$app->request->getBodyParam('hardware_id');
        $password = Yii::$app->request->getBodyParam('password');
        $set_password = "4242564";

        if ($set_password == $password){
            Queue::push($id, $hardware_id);

            return "Success Push: ". $hardware_id;
        }
        
        return "Incorrect Password";
    }

    // requested by He lin for temp solution
    public function actionOpenAll($key=null)
    {
        $id = 1;
        $hardware_id = "00OK";
        $set_password = "4242564";

        if ($key){
            if ($set_password == $key){
                Queue::push($id, $hardware_id);
    
                return "Success Push: ". $hardware_id;
            }
        }

        return "Incorrect Password";
    }
}
