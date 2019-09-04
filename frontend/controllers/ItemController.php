<?php

namespace frontend\controllers;

use Yii;
use common\models\Item;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
//ItemController implements the CRUD actions for Item model.
class ItemController extends Controller
{

    // 显示 Item表 其中一个数据 详情
    public function actionView($id)
    {
        $model=Item::findOne($id);
        if ($model!=null)
        {
            return $this->render('view', [
                'model' => $model,
            ]);
        }
        else {
            throw new NotFoundHttpException("I can't find this product.");
        }

    }


}
