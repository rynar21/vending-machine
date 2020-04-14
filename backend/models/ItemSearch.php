<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Item;
use common\models\Product;

/**
 * ItemSearch represents the model behind the search form of `common\models\Item`.
 */
class ItemSearch extends Item
{
     public $name;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'box_id','store_id'], 'integer'],
            [['name'], 'safe'],
            [['price'], 'number'],
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
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Item::find();
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
            'price' => $this->price,
            'box_id' => $this->box_id,
            'status' =>$this->status,
        ]);
        $query->joinWith('product');
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     * @param array $params
     * @return ActiveDataProvider
     */
    public function searchAvailableItem($params, $id)
    {
        $query = Item::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['box_id'=>SORT_ASC])->where([
                        'item.status'=> [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],
                        'store_id'=> $id
                        ]),
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            return '';
        }

        $query->joinWith('product');
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        return $dataProvider;
    }

    public function searchBoxItem($params, $box_id,$store_id)
    {
        $query = Item::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'price' => $this->price,
            'box_id' => $box_id,
            'status' =>$this->status,
            'store_id' => $store_id,
        ]);
        $query->joinWith('product');
        $query->andFilterWhere(['like', 'product.name', $this->name]);
        return $dataProvider;
    }
}
