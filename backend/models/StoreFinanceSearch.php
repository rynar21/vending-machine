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
        ->andWhere(['between','created_at' , $date, $date+86399])->all();

        if ($models)
        {
            foreach ($models as $salerecord_model)
            {
                $store_all_data[] =  array(
                    'store_id' => $salerecord_model->store_id ,
                    'date' => $date,
                );
            }

            $store_all_data = Finance::remove_duplicate($store_all_data);

            return $store_all_data;
        }

        return array();

    }

}
