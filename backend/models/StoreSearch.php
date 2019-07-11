<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;

/**
 * StoreSearch represents the model behind the search form of `common\models\Store`.
 */
class StoreSearch extends Store
{

    public $store_contact;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['store_id'], 'integer'],
            [['store_name', 'store_description'], 'safe'],

            ['store_contact', 'required'],
            ['store_contact','match','pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            ['store_contact', 'string', 'min'=>11,'max' => 11],
            ['store_contact', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已经被占用.'],
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
        $query = Store::find();

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
            'store_id' => $this->store_id,
        ]);

        $query->andFilterWhere(['like', 'store_name', $this->store_name])
            ->andFilterWhere(['like', 'store_description', $this->store_description]);

        return $dataProvider;
    }
}
