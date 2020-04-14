<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Finance;
use common\models\Store;
use common\models\SaleRecord;

/**
 * FinanceSearch represents the model behind the search form of `common\models\Finance`.
 */
class FinanceSearch extends Finance
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'quantity_of_order', 'created_at', 'updated_at'], 'integer'],
            [['date'], 'safe'],
            [['date'], 'trim'],
            [['total_earn', 'gross_profit', 'net_profit'], 'number'],
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
        $query = Finance::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id'=>SORT_ASC]),
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quantity_of_order' => $this->quantity_of_order,
            'total_earn' => $this->total_earn,
            'gross_profit' => $this->gross_profit,
            'net_profit' => $this->net_profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'date', $this->date]);

        return $dataProvider;
    }

    public function searchDate($params,$date1,$date2)//根据用户输入的日期查询
    {
        $query = Finance::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id'=>SORT_ASC]),
        ]);

        $this->load($params);
        
        if (!$this->validate())
        {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'quantity_of_order' => $this->quantity_of_order,
            'total_earn' => $this->total_earn,
            'gross_profit' => $this->gross_profit,
            'net_profit' => $this->net_profit,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere([ 'between','date' ,$date1,$date2]);
        return $dataProvider;
    }
}
