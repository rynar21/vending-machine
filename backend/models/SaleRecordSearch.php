<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleRecord;
use yii\helpers\ArrayHelper;

/**
 * SaleRecordSearch represents the model behind the search form of `common\models\SaleRecord`.
 */
class SaleRecordSearch extends SaleRecord
{
    // public $transactionNumber;

    /**
     * {@inheritdoc}
     */
     public $text;
     public $storename;
     public $itemname;
    public function rules()
    {
        return [
            [['id', 'box_id', 'item_id','store_id', 'status'], 'integer'],
            [['storename','itemname'], 'safe'],
            [['order_number','box_code','store_name','item_name','storename','itemname','unique_id'], 'trim'],
            [['box_code','item_name','store_name','unique_id'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {

        $query = SaleRecord::find();

        $dataProvider = new ActiveDataProvider([
            'query' =>  $query->orderBy(['id'=>SORT_DESC]),
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'box_id' => $this->box_id,
            'item_id' => $this->item_id,
            'status' => $this->status,
            'sell_price' => $this->sell_price,
            'box_code' => $this->box_code,
            'order_number' =>$this->order_number,
            'unique_id' => $this->unique_id
        ]);

        if ($this->itemname)
        {
            $query->joinWith('product');
        }

        if ($this->storename)
        {
            $query->joinWith('store');
        }
        
        if ($this->time_start) {
            $query->andFilterWhere(['>', 'sale_record.created_at', strtotime($this->time_start)]);
        }

        if ($this->time_end) {
            $query->andFilterWhere(['<', 'sale_record.created_at', strtotime($this->time_end) + (60 * 60 * 24 - 1)]);
        }
         //->andFilterWhere(['between','created_at' ,strtotime('2020-02-11'),(strtotime('2020-02-11')+86399)])
        $query->andFilterWhere(['like','product.name' , $this->itemname])
        ->andFilterWhere(['like', 'store.name', $this->storename])
        ->orFilterWhere(['like','unique_id',$this->unique_id]);

        return $dataProvider;
    }


    
}
