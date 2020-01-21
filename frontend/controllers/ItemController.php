<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;
use common\models\SaleRecord;
use yii\web\NotFoundHttpException;
//ItemController implements the CRUD actions for Item model.
class ItemController extends Controller
{
    public function actionIndex()
    {
        // 获取 ItemSearch 数据表
        $searchModel = new ItemSearch();
        // 使用输入字段 进行搜索功能
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 当前 显示 index 页面 及 带入相关数据
        return $this->render('/box/_view', [
            'searchModel' => $searchModel,      // ItemSearch Model
            'dataProvider' => $dataProvider,    // 搜索Item数据
        ]);
    }

    // 显示 Item表 其中一个数据 详情
    public function actionView($id)
    {
        $model=Item::findOne(['id'=>$id]);
        if ($model && $model->status!=10)
        {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        else {
            throw new NotFoundHttpException("Requested item cannot be found.");
        }

    }


}
