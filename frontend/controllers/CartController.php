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
class CartController extends Controller
{
    public function actionIndex()
    {
        $sum =0;
        $test = "ok!";
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        if(Yii::$app->request->post())
        {
            $data=Yii::$app->request->post();
            $id= $_POST["id"];

            for ($i=0; $i <=count($id)-1 ; $i++) {
               $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
               $this->redirect(Url::to(['item/view','id'=>$id[$i]]));
            }
        }

        if (Yii::$app->request->isAjax) {

            $model= Item::find()->where(['id'=>25])->one();
            return [
               'label' => $test,
               'item_name'=>$model->name,
            ];
        }

    }
    //把商品加入购物车
    public  function actionCreate()
    {
        $sum = 0;
        $model = new Item();
        $store_id = Yii::$app->request->post('store_id');
        if ($model->load(Yii::$app->request->post()))
        {
            if ( Yii::$app->request->post('ok')) {
                $id= Yii::$app->request->post('ok');
                for ($i=0; $i <=count($id)-1 ; $i++) {
                    $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
                }
                $item_model=Item::find()->where(['id'=>$id])->all();
                //return  $this->redirect(Url::to(['item/view','id'=>$id]));
                return $this->render('ordergroup', [
                    'sum'=>$sum,
                    'item_model'=>$item_model,
                    'id'=> $_POST['ok'],
                    'store_id'=>$store_id,
                ]);
            }
            //返回主页
            else {
                return  $this->redirect(Url::to(['store/view','id'=>$store_id],
                Yii::$app->session->setFlash('error', 'Sorry, You must choose at least one item.')));
            }
        }
        else {
            return  $this->redirect(Url::to(['store/view','id'=>$store_id],
            Yii::$app->session->setFlash('error','Sorry, You must choose at least one item.')));
        }

    }
    //数组对比取不同值
    function array_sort($vectorA,$vectorB)
    {
        $cantA = count($vectorA);
        $cantB = count($vectorB);
        $nuevo_array = [];
        $No_saca = 0;
        for($i = 0;$i <$cantA;$i++)
        {
            for($j = 0;$j <$cantB;$j++)
            {
                if($vectorA[$i] == $vectorB[$j])
                $No_saca = 1;
            }
            if($No_saca == 0)
            $nuevo_array[] = $vectorA[$i];
            else
            $No_saca = 0;
        }
       return $nuevo_array;

    }
    //购物车删减商品
    public function actionDelete()
    {

        $request = \Yii::$app->request;//获取商品信息
        $id = array($request->get('id'));
        $a = $request->get('item_id');
        $store_id = $request->get('store_id');
        $b = $this->restadearrays($a,$id);
        $sum = 0;
        $model = new Item();

             for ($i = 0; $i <=  count($b)-1 ; $i++) {
                 $sum += Item::find()->where(['id' => $b[$i]])->one()->price;
             }
             $item_model = Item::find()->where(['id' => $b])->all();
             //return  $this->redirect(Url::to(['item/view','id'=>$id]))
             return $this->render('ordergroup', [
                 'sum' => $sum,
                 'item_model' => $item_model,
                 'id' => $b,
                 'store_id' => $store_id,
             ]);
    }
    // 购物车创建订单
    public  function actionCreateOrder()
    {
        $request = \Yii::$app->request;//获取商品信息
        $id =$request->get('id');
        $store_id=$request->get('store_id');
        if ($id) {
            $sum =0;
            for ($i=0; $i <=count($id)-1 ; $i++){
                $item_model = Item::findOne($id[$i]); // 寻找 Item
                $model = new SaleRecord(); // 创建 新订单
                $model->item_id = $id[$i];
                $model->box_id = $item_model->box_id;
                $model->store_id = $item_model->store_id;
                $model->sell_price = $item_model->price;
                $model->save();
                $salerecord_id[] = $model->id;
            }
            for ($i=0; $i <=count($id)-1 ; $i++) {
                $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
            }
            $item_model=Item::find()->where(['id'=>$id])->all();
            return $this->render('orderpay',[
                'id'=>$id,
                'sum'=>$sum,
                'item_model'=>$item_model,
                 'store_id'=>$store_id,
                 'salerecord_id'=>$salerecord_id,
            ]);
        }
        if (empty($id)) {
            return  $this->redirect(Url::to(['store/view','id'=>$store_id],
            Yii::$app->session->setFlash('error','Sorry,you Choose at least one item.')));
        }
    }

    //购物车返回商店
    public function actionCancel()
    {
        $request = \Yii::$app->request;//获取商品信息
        $id =$request->get('salerecord_id');
        $store_id=$request->get('store_id');
        if ($id) {
            for ($i=0; $i <=count($id)-1 ; $i++){
                $model = SaleRecord::findOne(['id' => $id[$i]]);
                $model->failed();
            }
        }

        return  $this->redirect(Url::to(['store/view','id'=>$store_id]));
    }



}
