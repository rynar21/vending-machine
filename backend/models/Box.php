<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Box as BoxModel;

/**
 * Box represents the model behind the search form of `common\models\Box`.
 */
class Box extends BoxModel
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['box_id', 'box_code', 'box_status', 'store_id'], 'integer'],
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
        $query = BoxModel::find();

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
            'box_id' => $this->box_id,
            'box_code' => $this->box_code,
            'box_status' => $this->box_status,
            'store_id' => $this->store_id,
        ]);

        return $dataProvider;
    }
}
