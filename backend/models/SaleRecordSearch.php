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
    public function rules()
    {
        return [
            [['id', 'box_id', 'item_id','store_id'], 'integer'],
            [['status'], 'filter', 'filter' => function($text)
            {
                switch ($text)
                {
                    case 'success':
                        $this->status = 10;
                        break;
                    case 'failed':
                        $this->status = 8;
                        break;
                    case 'pending':
                        $this->status = 9;
                        break;
                    default:
                        break;
                }
                return $this->status;
            }],
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

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
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
            'box_id' => $this->box_id,
            'item_id' => $this->item_id,
            'status' => $this->status,
            'store_id' => $this->store_id,
        ]);

        return $dataProvider;
    }
}
