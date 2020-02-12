<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;
use common\models\Item;
use common\models\User;
/**
 * StoreSearch represents the model behind the search form of `common\models\Store`.
 */
class StoreSearch extends Store
{
    public $manager;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['manager'], 'safe'],
            [['name', 'address'], 'safe'],
            ['contact', 'number'],

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

        if (!$this->validate())
        {
            // uncomment the following line if you do not want to return any records when validation fails
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'status' => $this->status,

        ]);
        if ($this->manager) {
            $query->joinWith('user');
        }
        $query->andFilterWhere(['id' => $this->id,'contact' => $this->contact,])
            ->andFilterWhere(['like', 'user.username', $this->manager])
            ->andFilterWhere(['like', 'name', $this->name,])
            ->andFilterWhere(['like', 'address', $this->address,]);

        return $dataProvider;
    }
}
