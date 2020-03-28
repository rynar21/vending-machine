<?php

namespace frontend\controllers;

use Yii;
use common\models\Box;
use backend\models\BoxSearch;
use common\models\SaleRecord;
use common\models\Product;
use yii\web\Controller;
use common\models\Queue;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

// BoxController implements the CRUD actions for Box model.
class ApiController extends Controller
{

    public  function actionRequest($id)
    {

        $model = Queue::find()->where(['store_id'=>$id,'status'=>Queue::STATUS_WAITING])
        ->orderBy(['created_at'=>SORT_ASC])->one();
        if ($model) {

            $data =  ['command'=>$model->action];
            $data = json_encode($data, 320);
            return $data;
        }
        else {
            $data = ['status'=>'ok'];
            $data = json_encode($data, 320);
            return $data;
        }
    }
    public function actionNext($id)
    {
        $model = Queue::find()->where(['store_id'=>$id,'status'=>Queue::STATUS_WAITING])
        ->orderBy(['created_at'=>SORT_ASC])->one();
        if ($model) {
            $model->status = Queue::STATUS_SUCCESS;
            $model->save();
        }
        $data = ['status'=>'ok'];
        $data = json_encode($data, 320);
        return $data;

    }
}
