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

        $query->andFilterWhere(['like','product.name' , $this->itemname])
        ->andFilterWhere(['like', 'store.name', $this->storename])
        ->orFilterWhere(['like','unique_id',$this->unique_id]);

        return $dataProvider;
    }


    //单个商店某一天的所有订单
    public function searchStoreAllsalerecord($params,$array)//$store_id,$date
    {
        $store_id   = ArrayHelper::getValue($array,'store_id',Null);
        $date       = ArrayHelper::getValue($array,'date',Null);
        $box_id     = ArrayHelper::getValue($array,'box_id',Null);

        $query      = SaleRecord::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate())
        {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'status' => SaleRecord::STATUS_SUCCESS,
            'store_id' => $store_id,
            'box_id' => $box_id,
            'box_code' => $this->box_code,
            'order_number' =>$this->order_number,
            //'store_name' =>$this->store_name,
            //'item_name' =>$this->item_name,
        ]);

        //$query->joinWith('product');
         $query->andFilterWhere(['between', 'created_at', $date, $date + 86399])
         ->andFilterWhere(['like','item_name', $this->itemname])
         ->orFilterWhere(['like', 'store_name', $this->store_name])
         ->orFilterWhere(['like','box_code', $this->text])
         ->orFilterWhere(['like','unique_id', $this->unique_id]);

        return $dataProvider;
    }

}
