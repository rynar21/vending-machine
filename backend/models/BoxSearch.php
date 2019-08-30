<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Box;
use common\models\Item;

/**
 * BoxSearch represents the model behind the search form of `common\models\Box`.
 */
class BoxSearch extends Box
{

    public $name;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code' , 'store_id'], 'integer'],
            [['name', 'price'], 'safe'],
            [['name','status'],'string'],
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
        $pro_name= Item::find();
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
            'code' => $this->code,
            'status' => $this->status,
            'store_id' => $this->store_id,
        ]);
        $query->joinWith('item');
        $pro_name->joinWith('product');
        if ($stu= $this->item) {
            $query->andFilterWhere(['like', 'product.name',$stu->product->name]);
        }


        return $dataProvider;
    }

    // if($stu= $this->item)
    // {
    //     return    $stu->product->name;
    // }

}
