<?php

namespace console\controllers;
use Yii;

use common\models\SaleRecord;
use common\models\Box;
use common\models\User;
use common\models\Product;
use common\models\Store;
use common\models\Item;
use common\models\Queue;
use common\models\Finance;
use yii\helpers\ArrayHelper;
use yii\console\Controller;

class TestController extends Controller {

    public function actionIndex()
    {
        echo "hello_world";
    }

    public function actionCreateAdmin($username,$password)
    {
        $model = new User();
        $model->email = 'forgetof2@gmail.com';
        $model->username = $username;
        $model->password_hash = Yii::$app->security->generatePasswordHash($password);
        $model->auth_key = Yii::$app->security->generateRandomString();
        $model->status = User::STATUS_ACTIVE;
        $model->save();
        $auth = Yii::$app->authManager;
        $auth->revokeAll(1);
        $auth_role = $auth->getRole('admin');
        $auth->assign($auth_role, 1);
        if ($model->save()) {
            echo "ok";
        }
        else {
            echo "false";
        }
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

     public function actionSales()
     {
        $data = $this->store_finance('1581350400');
        $filtered = array_filter($data, function($item){
                         return $item['store_id'] == '1';
                    });
        print_r($data);
        echo "\n";
        print_r($filtered);

     }

     public function store_finance($date)       //写入日期查询当天所有卖过商品的店
     {
         $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
         ->andWhere(['between','created_at' ,$date,$date+86399])->all();
         if ($models) {
             foreach ($models as $salerecord_model) {

                 $store_all_data[] =  array('store_id' =>$salerecord_model->store_id , 'date' =>$date);
             }
             //$a = array_unique($store_id); // 维数组去重复
             $store_all_data = $this->array_unique_fb($store_all_data);
             return $store_all_data;
         }

         if (empty($store_id)) {
             return false;
         }
     }
     ///
     public function actionSale()
     {

         $str= '2020-02-01/2020-02-29';
         $arr = explode('/',$str);
         $model = array();
         $datas = $this->get_store_salerecord(['date1'=>$arr[0],'date2'=>$arr[1]]);
         //$fields = ['date','order_number','box_code','store_name','sell_price','cost','creation_time','end_time'];
         print_r($datas);
     }
     public  function get_store_salerecord($array) //导出roder
     {
         $date1 = ArrayHelper::getValue($array,'date1',Null);
         $date2 = ArrayHelper::getValue($array,'date2',Null);
         $store_id = ArrayHelper::getValue($array,'store_id',Null);
         $catime1 = strtotime($date1);
         $catime2 = strtotime($date2);
        // $all_order = [];
        // print_r((strtotime($date2)-strtotime($date1)+86400)/86400);
        // echo "\n";
         if (empty($store_id)) {
             for ($i = 1; $i <=(strtotime($date2)-strtotime($date1)+86400)/86400 ; $i++) {
                 $date = $catime1+86400*($i)-86400;
                 $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
                 ->andWhere(['between','created_at' ,$date,$date+86399])
                 ->andWhere(['store_id'=>7])
                 ->all();
                 //echo "1";
                 print_r(count($models));
                 if ($models) {
                     foreach ($models as $model) {
                         $all_order[] = array('date'=>date('d-m-Y',$date),
                         'order_number' => $model->order_number,
                         'box_code' =>$model->box_code,
                         'store_name'=>$model->store->name,
                         'item_name'=> $model->item->name,
                         'sell_price' => $model->sell_price,
                         'cost' => product::find()->where(['id'=>$model->item->product_id])->one()->cost,
                         'creation_time'=>date('d-m-Y H:i:s', $model->created_at),
                         'end_time'=>date('d-m-Y H:i:s', $model->updated_at),
                         );
                        // echo "2";
                         //print_r($all_order) ;
                     }
                 }
             }

         }
         return $all_order;
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




    public function actionUp()
    {
        // $id = 7;
        // box::updateAll(['status'=>1],['store_id'=>$id]);
        // $model = new Queue();
        // $model->store_id = 1;
        // $model->action ='M2';
        // $model->priority = '123';
        // //$model->save();
        // if ($model->save()) {
        //     echo "ok";
        // }
        //var_dump($model->getErrors());
        $model = Queue::find()->where(['store_id' => 1, 'status'=> 0])
        ->orderBy(['created_at'=>SORT_ASC])->one();
        if ($model) {
            $model->status = 1;
            $model->save();
            print_r($model->action);
        }

    }



}
?>
