<?php

namespace frontend\controllers;

use Yii;
use common\models\Box;
use backend\models\BoxSearch;
use common\models\SaleRecord;
use yii\web\Controller;
use common\models\Item;
use yii\data\Pagination;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

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

    public  function actionList()
    {
        $sum =0;
        $model = new Item();
        if ($model->load(Yii::$app->request->post()))
        {

             $id= Yii::$app->request->post('ok');
             for ($i=0; $i <=count($id)-1 ; $i++) {
                 $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
             }
             $item_model=Item::find()->where(['id'=>$id])->all();
             //return  $this->redirect(Url::to(['item/view','id'=>$id]));
             $this->A(['a'=>$id]);
             return $this->render('ordergroup', [
                 'sum'=>$sum,
                 'item_model'=>$item_model,
                 'id'=> $_POST['ok'],
             ]);

        }



    //return  $this->redirect(Url::to(['item/view','id'=>13]));
    }
    function RestaDeArrays($vectorA,$vectorB)
    {
      $cantA=count($vectorA);
      $cantB=count($vectorB);
      $nuevo_array=[];
      $No_saca=0;
      for($i=0;$i<$cantA;$i++)
      {
        for($j=0;$j<$cantB;$j++)
        {
         if($vectorA[$i]==$vectorB[$j])
         $No_saca=1;
        }
       if($No_saca==0)
       $nuevo_array[]=$vectorA[$i];
       else
       $No_saca=0;
       }
       return $nuevo_array;

    }
    public function actionBox()
    {

        $request = \Yii::$app->request;//获取商品信息
        $id =array($request->get('id'));
        $a=$request->get('item_id');
        $b=$this->restadearrays($a,$id);
        // print_r($id);
        // print_r($a);
        //
        //  var_dump($b);
        //  print_r($b);
        $sum =0;
        $model = new Item();

             for ($i=0; $i <=count($b)-1 ; $i++) {
                 $sum+=Item::find()->where(['id'=>$b[$i]])->one()->price;
             }
             $item_model=Item::find()->where(['id'=>$b])->all();
             //return  $this->redirect(Url::to(['item/view','id'=>$id]))
             return $this->render('ordergroup', [
                 'sum'=>$sum,
                 'item_model'=>$item_model,
                 'id'=> $b,
             ]);
        


        // print_r($id);
        // print_r($a);
    }

    public function A($array)
    {
        $a=ArrayHelper::getValue($array,'a',[]);
        $b=ArrayHelper::getValue($array,'b',[]);
        return $b;
    }

    public  function actionGpay()
    {
        $sum =0;
        $request = \Yii::$app->request;//获取商品信息
        $id =$request->get('id');
        //print_r($id);
         for ($i=0; $i <=count($id)-1 ; $i++) {
                 $item_model = Item::findOne($id[$i]); // 寻找 Item
                 $model = new SaleRecord(); // 创建 新订单
                 $model->item_id = $id[$i];
                 $model->box_id = $item_model->box_id;
                 $model->store_id = $item_model->store_id;
                 $model->sell_price =$item_model->price;
                 $model->save();
                 // $salerecord=SaleRecord::find()->where(['item_id' => $id[$i], 'status'=> SaleRecord::STATUS_PENDING])
                 // ->orderBy(['created_at'=>SORT_ASC, 'id'=>SORT_ASC])->one();
                 //
                 // if ($model->id==$salerecord->id)
                 // {
                 //     //Yii::$app->slack->Skey(['price'=>1->price,'id'=>$model->id,]);
                 //     return $this->redirect(['sale-record/check','id'=>$model->id]);
                 //
                 // }

         }
         for ($i=0; $i <=count($id)-1 ; $i++) {
             $sum+=Item::find()->where(['id'=>$id[$i]])->one()->price;
         }
         $item_model=Item::find()->where(['id'=>$id])->all();
         return $this->render('orderpay',[
             'sum'=>$sum,
             'item_model'=>$item_model,
         ]);
         // return $this->redirect(Url::to(['salerecord/create','id'=>12]));
    }

}
