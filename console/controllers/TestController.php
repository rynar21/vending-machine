<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use common\models\Box;
use common\models\Product;
use common\models\Store;
use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }

    // 检查支付状态
    public  function actionInspection()
    {

        $models = SaleRecord::find()->where([
            'status' => SaleRecord::STATUS_PENDING,
        ])->andWhere(['<', 'created_at', time()-1])->all();
                if ($models) {
                    foreach ($models as $model) {
                            $model->failed();
                            echo $model->id . "\n";
                    }
              }

     }
     //上传.......
     public function actionReplace()
     {
         $p=1;
         $j=1;
         $turl='C:\Users\user\Desktop\up';//上传的新文件的目录
         $txt = file_exists($turl);//检查文件或目录是否存在
         $arr = scandir($turl);
         $all = count($arr)-2;
         // print_r($all);
         // die();
         if ($txt)
         {
                 $filename='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//创建文本文档记录旧文件路径
                 $handles=fopen($filename,"a+");
                 $path = $turl;///当前目录
                 $handle = opendir($path); //当前目录
                 $time=time();
                 while (false !== ($file = readdir($handle)))
                 { //遍历该php文件所在目录
                     list($filesname,$kzm)=explode(".",$file);//获取扩展名
                     if($kzm=="gif" or $kzm=="jpg" or $kzm=="JPG" or $kzm=="png")
                     { //文件过滤
                         if (!is_dir('./'.$file))
                         { //文件夹过滤
                             $array[]=$file;//把符合条件的文件名存入数组
                             $name = strstr($file,'.',true);//取文件的名字
                             $ext = explode(".", $file);//拆分获取图片名
                             $extt = $ext[count($ext) - 1];//取图片的后缀名
                             $model=Product::find()->where(['name'=>$name])->one();
                                 if ($model )
                                  {
                                         if ($model->image)
                                         {
                                             fwrite($handles,$model->image.'_'.$model->id."\n");//写入旧文件路径到文本文档
                                             $model->image=$name.".".$extt.".bak";
                                             $model->save();
                                             $src = $turl.'/'.$file;//替换的文件的目录
                                             $dst = Yii::getAlias('@upload').'/'.$model->image;//新文件目录
                                             rename($src, $dst);//文件移动到指定目录
                                             if (time()-$time==$p) {
                                                 $t=(time()-$time)/$j*$all;
                                                 $s=(time()-$time)/$j*($all-$j);
                                                 printf("\33[2K\r");
                                                 echo  "进度:".$j."/".$all."____".sprintf("%.2f",($j/($all*0.01)))."%____预计:".sprintf("%.2f",$t)."s_____剩余:".sprintf("%.2f",$s).'s';
                                                 $p++;
                                             }
                                             if ($j==$all) {
                                                 printf("\33[2K\r");
                                                 echo  "进度:".$all."/".$all."____100%____预计:0s_____剩余:0s________用时:".$p."s";
                                             }
                                             $j++;
                                         }

                                 }
                             }
                         }

                 }
              fclose($handles);//关闭txt
            }




     }
     //回滚
     public function actionSo()
     {
         $turl='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//文本路径
             $j=1;
             $lines=file($turl);//逐行读取内容
             foreach ($lines as $file)
             {
                 $name = substr($file,0,strrpos($file,'_'));//取文件的名字
                 $ext = explode("_", $file);//拆分获取图片名
                 $id= $ext[count($ext) - 1];//获取文件的id

                 // print_r($id);
                 // die();
                 $model = Product::find()->where(['id'=>$id])->one();
                     if ($model)
                     {

                         if($model->image){
                             $na = substr($model->image,strrpos($model->image,"."));//截取后缀名
                             // print_r($name);
                             // die();
                             if ($na==".bak") {//检查是否备份文件
                                 if (file_exists(Yii::getAlias('@upload') . '/' .  $model->image))//
                                 {
                                      unlink(Yii::getAlias('@upload') . '/' . $model->image);//删除原来的文件
                                 }
                                 $model->image = $name ;//替换数据库路径
                                 $model->save();//保存
                                 printf("\33[2K\r");
                                 echo  "进度:".$j++."/".count($lines);
                             }
                         }

                     }
            }
            file_put_contents($turl,"");//清空文本
     }

     public function actionGenerate()
     {
         $turl='C:\Users\user\Desktop\image\logo.png';
         $url='C:\Users\user\Desktop\up';
         //$urlp='D:\wamp64\www\vending-machine\backend\web\mel-img\img';
         $k=57;
         $j=1;
             for ($i=1; $i <=$k ; $i++) {
                 copy($turl,$url.'/'. $i .'.png');
                 printf("\33[2K\r");
                 echo  "进度:".$j++."/".$k;

             }

         //echo 'ok';
     }

     public function actionCountp()
     {
         $k=3000;
         //$turl='C:\Users\user\Desktop\image\apple.jpg';
         //$url='D:\wamp64\www\vending-machine\backend\web\mel-img\img';
         $modelkey =['id','sku','name','price','image','created_at','updated_at'];//测试数据键
         for ($i=1; $i <=$k ; $i++) {
             $modelvale[] = array($i,'SKU0000'.$i, "$i",7,'/img'.'/'.$i.'.jpg',time(),time());
         }
         $res= \Yii::$app->db->createCommand()->batchInsert(Product::tableName(), $modelkey, $modelvale)->execute();
         echo "ok";
     }

     public function actionDelete()
     {
         $url='';
         array_map('unlink',glob('C:\Users\user\Desktop\up/*'));
         echo "ok";
     }

     public function actionDtxt()
     {
          $turl='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//文本路径
          file_put_contents($turl,"");//清空文本
          echo "ok";
     }
     public function actionCp()
     {
        $src='C:\Users\user\Desktop\up';//上传的新文件的目录
        $dst=Yii::getAlias('@upload') ;
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) ) {
            if (( $file != '.' ) && ( $file != '..' )) {
                if ( is_dir($src . '/' . $file) ) {
                    recurse_copy($src . '/' . $file,$dst . '/' . $file);
                }
                else {
                    rename($src . '/' . $file,$dst . '/' . $file);
                    echo $file."\n";
                }
            }
        }
        closedir($dir);
        echo "ok";
     }
     public  function actionText()
     {
         $k=999;
         $filename='D:\wamp64\www\vending-machine\backend\web\mel-img\a.txt';//创建文本文档记录旧文件路径
         $handle=fopen($filename,"a+");
         for ($i=1; $i <=$k ; $i++) {

             $str=fwrite($handle,'/img'.'/'.$i.'.jpg'.'_'.$i."\n");//写入旧文件路径到文本文档
              printf("\33[2K\r");
              //echo $i."/100000";
              printf("进度：%d/999",$i);
         }
         fclose($handle);
        echo "\n"."ok";
     }

     public function actionJd()
     {
          // @ob_start();
          // $shell = system("tput cols");
          // @ob_end_clean();
          // for( $i= 0 ; $i < 50 ; $i++ )
          // {
          //     echo"█";
          //     usleep(10000*2*2);
          //      //printf("\33[2K\r");
          // }
            $j=1;
            for($i=1;$i<=100;$i++)
            {
                printf("\33[2K\r");
                printf("安装进度：%d/100",$i);
                //fflush(stdout);
                echo $j++;
                usleep(1000*1000);
            }
            //printf("\n");



     }

}
?>
