<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Box;
use common\models\Store;
use common\models\Item;
use common\models\Product;

/**
 * BoxSearch represents the model behind the search form of `common\models\Box`.
 */
class BoxSearch extends Box
{

    public $name;
    public $price;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code' , 'store_id'], 'integer'],
            [['status'], 'safe'],
            [['name'], 'safe'],
            [['price'], 'number'],
            // [['name'],'string'],
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
        $query = Box::find();
        //->where(['store_id'  =>$st->id]);
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query

            //Box::find()->where(['store_id'  =>1])
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            // 'id' => $this->id,
            // 'code' => $this->code,
            'box.status' => $this->status,
            'box.store_id' => $this->store_id,
            'product.name' => $this->name,
        ]);

        if ($this->name) {
            $query->joinWith('product');
        }
            // $query->andFilterWhere(['like', 'item.name', $this->name]);
            // $query->andFilterWhere(['like', 'item.price', $this->price]);


        return $dataProvider;
    }



}
