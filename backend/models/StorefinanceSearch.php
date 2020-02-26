<?php

namespace backend\models;

use yii\data\ArrayDataProvider;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;
use common\models\Item;
use common\models\User;
use common\models\Finance;
use common\models\SaleRecord;
use common\models\Product;
/**
 * StoreSearch represents the model behind the search form of `common\models\Store`.
 */
class StoreFinanceSearch extends Model
{
    public $store_name;
    public $store_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['store_name','store_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'store_name'=> 'Store Name',

        ];
    }

     /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function storeAllfinancesearch($params,$date)
    {
        $query = $this->store_finance($date);
        $dataProvider = new ArrayDataProvider([
            'allModels' => $query,
            // 'key' => function ($model) {
            //     return md5($this->store_id);
            // },
            //'pagination' => 30, // 可选 不分页
            // 'sort' => [
            //     'attributes' => ['store_id'],
            // ],
        ]);
        //$this->load($params);
        if (!$this->validate()) {

            return $dataProvider;
        }
        if ($this->load($params)) {
            //$this->store_id = strtolower(trim($this->store_id));
            $filtered = array_filter($query, function($item){
                             return $item['store_id'] == $this->store_id;
                        });
            $dataProvider = new ArrayDataProvider([
                'allModels' => $filtered,
            ]);

        }

        return $dataProvider;
    }

    public function store_finance($date)       //写入日期查询当天所有卖过商品的店
    {
        $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
        ->andWhere(['between','created_at' ,$date,$date+86399])->all();
        if ($models) {
            foreach ($models as $salerecord_model) {
                $store_all_data[] =  array('store_id' =>$salerecord_model->store_id , 'date' =>$date,
                //'store_name'=> Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['store_name'],
                //'manager' => Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['store_manager'],
                // 'quantity_of_order'=>Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['quantity_of_order'],
                // 'total_earn'=>Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['total_earn'],
                // 'gross_profit'=>Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['total_earn'],
                // 'net_profit'=>Finance::find_store_one_finance_oneday($salerecord_model->store_id,$date)['net_profit'],
                );
            }
            $store_all_data = Finance::array_unique_fb($store_all_data);
            return $store_all_data;
        }

        else {
            return array();
        }
    }

    //二维数组去重
    // function array_unique_fb($array2D){
    //
    //      foreach ($array2D as $v){
    //       $v=join(',',$v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
    //       $temp[]=$v;
    //      }
    //      $temp=array_unique($temp); //去掉重复的字符串,也就是重复的一维数组
    //      foreach ($temp as $k => $v){
    //        $temp[$k] =  array('store_id' =>explode(',',$v)[0] , 'date' => explode(',',$v)[1]); //再将拆开的数组重新组装
    //      }
    //      return $temp;
    //
    // }

}
