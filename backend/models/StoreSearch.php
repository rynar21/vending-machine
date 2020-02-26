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
    public $username;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id','status'], 'integer'],
            [['name', 'address','username'], 'safe'],
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
        if ($this->username) {
            $query->joinWith('user');
        }
            $query->andFilterWhere(['id' => $this->id,'contact' => $this->contact,])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'name', $this->name,])
            ->andFilterWhere(['like', 'address', $this->address,]);

        return $dataProvider;
    }


    //用户下的所有的店
    public function searchUserAllstore($params,$user_id)
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
        if ($this->username) {
            $query->joinWith('user');
        }
        $query->andFilterWhere([

            'user_id' => $user_id,

        ])
            ->andFilterWhere(['id' => $this->id,'contact' => $this->contact,])
            ->andFilterWhere(['like', 'user.username', $this->username])
            ->andFilterWhere(['like', 'name', $this->name,])
            ->andFilterWhere(['like', 'address', $this->address,]);

        return $dataProvider;
    }

}
