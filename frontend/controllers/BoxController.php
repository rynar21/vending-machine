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

    public  function actionList()
    {
        $sum =0;
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
        $store_id=$request->get('store_id');
        $b=$this->restadearrays($a,$id);
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
                 'store_id'=>$store_id,
             ]);
    }

    public  function actionGpay()
    {

        $request = \Yii::$app->request;//获取商品信息
        $id =$request->get('id');
        $store_id=$request->get('store_id');
        //print_r($id);
        // $salerecord_id=[];
        if ($id) {
            $sum =0;
            for ($i=0; $i <=count($id)-1 ; $i++){
                $item_model = Item::findOne($id[$i]); // 寻找 Item
                $model = new SaleRecord(); // 创建 新订单
                $model->item_id = $id[$i];
                $model->box_id = $item_model->box_id;
                $model->store_id = $item_model->store_id;
                $model->sell_price =$item_model->price;
                $model->save();
                $salerecord_id[]=$model->id;
            }
            // print_r($salerecord_id);
            // die();
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


    public function actionCancelb()
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
    //jiaoben.......
    public function actionReplace()
    {
        //$array=[];
        $turl=Yii::getAlias('@url');//上传的新文件的目录
        $txt = file_exists($turl);//检查文件或目录是否存在
        if ($txt)
        {
                $path = $turl;///当前目录
                $handles = opendir($path); //当前目录
                while (false !== ($file = readdir($handles)))
                { //遍历该php文件所在目录
                    list($filesname,$kzm)=explode(".",$file);//获取扩展名
                    if($kzm=="jpeg"  | $kzm=="png" | $kzm=="jpg" )
                    { //文件过滤
                        if (!is_dir('./'.$file)) //文件夹过滤
                        {
                               //$array[]=$file;//把符合条件的文件名存入数组
                               $name = strstr($file,'.',true);//取文件的名字
                               $ext = explode(".", $file);//拆分获取图片名
                               $ext = $ext[count($ext) - 1];//取图片的后缀名
                               //print_r($ext);
                               $model = Product::find()->where(['sku'=>$name])->one();
                               if ($model)
                               {
                                   if($model->image){
                                       if (file_exists(Yii::getAlias('@upload') . '/' . $model->image))
                                       {
                                            $filename='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//创建文本文档记录旧文件路径
                                            $handle=fopen($filename,"a+");
                                            $str=fwrite($handle,$model->image.'_'.$model->id."\n");//写入旧文件路径到文本文档
                                            fclose($handle);
                                       }
                                   }
                                   //die();
                                       $model->image =  $name .'.'. $ext;//数据库写入新文件路径
                                       $model->save();
                                       echo "1";
                                       $src = $turl.'/'.$file;//替换的文件的目录
                                       $dst = Yii::getAlias('@upload').'/'.$model->image;//新文件目录
                                       rename($src, $dst);//文件移动到指定目录

                               }

                        }
                    }
                }

          }
          else {
              return false;
          }

    }

    public function actionSo()
    {
        $turl='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//文本路径
        $txt = file_exists($turl);//检查文件或目录是否存在
        if ($txt)
        {
               $lines=file($turl);//逐行读取内容
               foreach ($lines as $file) {
               //$line=explode(",",$file);
               $name = substr($file,0,strrpos($file,'_'));//取文件的名字
               $ext = explode("_", $file);//拆分获取图片名
               $id= $ext[count($ext) - 1];//获取文件的id
               $model = Product::find()->where(['id'=>$id])->one();
                   if ($model)
                   {
                       if($model->image){
                           if (file_exists(Yii::getAlias('@upload') . '/' . $model->image))
                           {
                                unlink(Yii::getAlias('@upload') . '/' . $model->image);//删除原来的文件
                                $model->image = $name ;//替换数据库路径
                                $model->save();//保存
                                echo "1";
                           }
                       }

                   }

            }
            file_put_contents($turl,"");//清空文本

          }
          else {
              return false;
          }
    }

}
