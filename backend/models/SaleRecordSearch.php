<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\SaleRecord;

/**
 * SaleRecordSearch represents the model behind the search form of `common\models\SaleRecord`.
 */
class SaleRecordSearch extends SaleRecord
{
    /**
     * {@inheritdoc}
     */
     public $text;
     public $stu;
    public function rules()
    {
        return [
            [['id', 'box_id', 'item_id','store_id', ], 'integer'],
            [['text'], 'safe'],
            [['status','box_code','item_name','store_name'], 'string'],
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
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        //$domain = strstr($this->status, 's');
        if (strstr($this->status, 's')||strstr($this->status, 'S')) {
            $this->stu=SaleRecord::STATUS_SUCCESS;
        }
        if (strstr($this->status, 'f')||strstr($this->status, 'F')) {
            $this->stu=SaleRecord::STATUS_FAILED;
        }
        if (strstr($this->status, 'p')||strstr($this->status, 'P')) {
            $this->stu=SaleRecord::STATUS_PENDING;
        }

        // grid filtering conditions
        // if ($this->status=='success'||$this->status=='Success'||$this->status=='S'||$this->status=='s') {
        //     $this->stu=SaleRecord::STATUS_SUCCESS;
        // }
        // if ($this->status=='failure'||$this->status=='Failure'||$this->status=='f'||$this->status=='F') {
        //     $this->stu=SaleRecord::STATUS_FAILED;
        // }
        // if ($this->status=='pending'||$this->status=='Pending'||$this->status=='p'||$this->status=='P') {
        //     $this->stu=SaleRecord::STATUS_PENDING;
        // }
        $query->andFilterWhere([
            'id' => $this->id,
            'box_id' => $this->box_id,
            'item_id' => $this->item_id,
            'status' => $this->stu,
            'store_id' => $this->store_id,
            'sell_price' => $this->sell_price,
            'box_code' => $this->box_code,

        ])
         ->andFilterWhere(['like','item_name' , $this->item_name])
         ->orFilterWhere(['like', 'store_name', $this->store_name])
         ->orFilterWhere(['like', 'created_at', $this->text])
         ->orFilterWhere(['like','box_code',$this->text])
         ->orFilterWhere(['like','unique_id',$this->unique_id]);
        return $dataProvider;
    }

}
