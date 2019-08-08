<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;

//ItemController implements the CRUD actions for Item model.
class ItemController extends Controller
{

    // 显示 Item表 其中一个数据 详情
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => Item::findOne($id),
        ]);
    }
    

}
