<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use common\models\Box;
use common\models\Product;
use common\models\Store;
use common\models\Item;
use common\models\Finance;
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
     //生成昨天的财务表
     public function actionFinance()
     {
         $total = Store::STATUS_INITIAL;
         $cost_price = Store::STATUS_INITIAL;
         $model = new Finance();
         $models = SaleRecord::find()->where([
             'status' => SaleRecord::STATUS_SUCCESS,
         ])->andWhere(['between',
                       'created_at' ,
                       strtotime(date('Y-m-d',strtotime('0'.' day'))),
                       strtotime(date('Y-m-d',strtotime('1'.' day')))])->all();
         if ($models) {
             foreach ($models as $salerecord_model) {
                 $arr = $salerecord_model->sell_price ;
                 $total += $arr;
                 $cost_price += $this->net_profit($salerecord_model->item_id);
             }
             $net_profit = $total - $cost_price;

             $model->date = date('Y-m-d',strtotime('0'.' day'));
             $model->quantity_of_order = count($models);
             $model->total_earn = $total;
             $model->gross_profit = $total;
             $model->net_profit = $net_profit;
             $model->save();
         }
         if (empty($models)) {
             $model->date = date('Y-m-d',strtotime('0'.' day'));
             $model->quantity_of_order = Finance::FINANCE_ININIAL_VALUE;
             $model->total_earn = Finance::FINANCE_ININIAL_VALUE;
             $model->gross_profit = Finance::FINANCE_ININIAL_VALUE;
             $model->net_profit = Finance::FINANCE_ININIAL_VALUE;
             $model->save();
         }

     }

     ///
     public function actionSale()
     {

         $catime = strtotime('2020-02-11');
         $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
         ->andWhere(['between','created_at' ,$catime,($catime+86399)])->all();
         if ($models) {
             foreach ($models as $salerecord_model) {

                 $store_all_data[] =  array('store_id' =>$salerecord_model->store_id , 'date' =>'2020-02-11');
             }
             //$a = array_unique($store_id); // 维数组去重复
             $store_all_data = $this->array_unique_fb($store_all_data);

             print_r($store_all_data);
             //return $store_all_data;
         }
     }

     //二维数组去重
     function array_unique_fb($array2D){

          foreach ($array2D as $v){
           $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
           $temp[]=$v;
          }
          $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
          foreach ($temp as $k => $v){
           //$temp[]=explode(',',$v); //再将拆开的数组重新组装
           $temp[$k] =  array('store_id' =>explode(',',$v)[0] , 'date' => explode(',',$v)[1]);
          }
          return $temp;

     }

     //二维数组变成一位数组
     function getarray($arr) {
        static $res_arr = array();
        foreach ($arr as $key => $val) {
            if (is_array($val)) {
                getarray($val);
            }
            else{
                $res_arr[] = $val;
            }
        }
        return $res_arr;
    }

     //本钱查询
     public function net_profit($id)
     {
            $p_id = Item::find()->where(['id'=>$id,])->one()->product_id;
            $model = Product ::find()->where(['id'=>$p_id])->one();
            if (!empty($model->cost)) {
                $cost_price = $model->cost;
                return $cost_price;
            }
            else {
                return 0;
            }
     }

}
?>
