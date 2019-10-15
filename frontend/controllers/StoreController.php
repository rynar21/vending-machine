<?php

namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Item;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
/**
 * StoreController implements the CRUD actions for Store model.
 */
class StoreController extends Controller
{

    // 显示 Store表 其中一个数据 详情
    // 采用 ItemSeearch表 来寻找 未购买成功的产品
    public function actionView($id)
    {
        $item_searchModel = new ItemSearch();
        $item_count=Item::find()->where(['status'=>0,'store_id'=>$id]);
        $countQuery = clone $item_count; //数据总条数
        $pages = new Pagination([    //数据分页
            'totalCount'=>$countQuery->count(),//分页对象
            'defaultPageSize'=>10,//每页放几条内容
        ]);
       //连贯查询每页的数据
        $item_dataProvider = $item_count->orderBy('id ASC')    //正序连贯查询
            ->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'id' => $id,
            'pages'=>$pages,
            'item_searchModel' => $item_searchModel,
            'item_dataProvider' => $item_dataProvider,
        ]);
    }
    
    protected function findModel($id)
    {
        if (($model = Store::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
