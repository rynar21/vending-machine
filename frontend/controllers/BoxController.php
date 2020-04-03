<?php

namespace frontend\controllers;

use Yii;
use common\models\Box;
use backend\models\BoxSearch;
use common\models\SaleRecord;
use common\models\Product;
use yii\web\Controller;
use common\models\Item;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

// BoxController implements the CRUD actions for Box model.
class BoxController extends Controller
{
    // 显示所有Item 数据


    public function actionIndex()
    {
        // 获取 ItemSearch 数据表
        $searchModel = new ItemSearch();
        // 使用输入字段 进行搜索功能
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 当前 显示 index 页面 及 带入相关数据
        return $this->render('_view', [
            'searchModel' => $searchModel,      // ItemSearch Model
            'dataProvider' => $dataProvider,    // 搜索Item数据
        ]);
    }

}
