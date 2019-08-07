<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use common\models\SaleRecord;
use frontend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

 //SaleRecordController implements the CRUD actions for SaleRecord model.
class SaleRecordController extends Controller
{

    // 显示 其中一个订单 详情
    public function actionView($id)
    {
        $model = SaleRecord::findOne(['item_id' => $id]);   // 寻找 SaleRecord
        return $this->render('view', [
            'item_model' => Item::findOne($id),
            'model' => $model,
        ]);
    }

    // 如果产品ID没有在于 SaleRecord 表里：创新新订单
    // 运行 购买流程
    public function actionCreate($id)
    {
        $item_model = Item::findOne($id);   // 寻找 Item
        // 创建 新订单
        if(empty(SaleRecord::findOne(['item_id' => $id])))
        {
            $model = new SaleRecord();
            $model->item_id = $id;
            $model->box_id = $item_model->box_id;
            $model->store_id = $item_model->store_id;
            $model->status = $model::STATUS_PENDING;
            $model->trans_id = (SaleRecord::find()->count())+1;
            $model->save();
        }

        return $this->render('update', [
            'item_model' => $item_model,
            'id' => $id,
        ]);
    }

    // 判断 交易订单 的状态
    public function actionCheck($id)
    {
        // 判断 订单是否存在
        if ($model = SaleRecord::findOne(['item_id' => $id]))
        {
            switch($model->status)
            {
                case $model::STATUS_PENDING:
                $model->pending();
                return $this->render('pending', [
                    'model' => $model,
                ]);
                break;

                case $model::STATUS_SUCCESS:
                $model->success();
                return $this->render('success', [
                    'model' => $model,
                ]);
                break;

                case $model::STATUS_FAILED:
                $model->failed();
                return $this->render('failed', [
                    'model' => $model,
                ]);
                break;

                default:
                throw new NotFoundHttpException('Undefined model status.');
                break;
            }
        }
        else {
            throw new NotFoundHttpException('The requested model does not exist.');
        }
    }

    public function actionPaySuccess($id)
    {
    $id = $model->status;
    
      return $id;
    }

    public function actionPayFailed()
    {
      $content = $_request;
      Error_log (Date ("[Ymdhis]"). " \ t ". Json_encode ($content). "\ r \ n", 3, ' ... /'. Date ("y-m-d"). '. Log1 ');

      $class _name = Getcollname ();
      Require_once App_root_path. " system/collocation/". $class _name." _collocation.php ";
      $collocation _class = $class _name. " _collocation ";
      $collocation _object = new $collocation _class ();
      $collocation _code = $collocation _object->sinanotify ($_post,$_request);
    }
}
