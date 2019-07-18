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
            [['id'], 'integer'],
            [['name', 'store_description'], 'safe'],

            ['contact', 'required'],
            ['contact','match','pattern'=>'/^1[0-9]{10}$/','message'=>'{attribute}必须为1开头的11位纯数字'],
            ['contact', 'string', 'min'=>11,'max' => 11],
            ['contact', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号码已经被占用.'],
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
            'id' => $this->id,
            'name' => $this->name,
            'contact' => $this->contact,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address]);

        return $dataProvider;
    }
}
