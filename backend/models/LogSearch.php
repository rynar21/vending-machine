<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Log;

/**
 * PmsLogSearch represents the model behind the search form of `app\common\models\PmsLog`.
 */
class LogSearch extends Log
{
    public $username;
    public $time_start = null;
    public $time_end = null;
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'status'], 'integer'],
            [['type', 'action', 'data_json', 'username'], 'safe'],
            [['type', 'action', 'username'], 'trim'],
            [['time_start', 'time_end'], 'safe'],
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
        $query = Log::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC
                ]
            ],
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        if ($this->username)
        {
            $query->joinWith('user');
        }

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'action', $this->action]);

        if ($this->username) {
            $query->andFilterWhere(['like', 'user.username', $this->username]);
        }

        if ($this->time_start) {
            $query->andFilterWhere(['>', 'log.created_at', strtotime($this->time_start)]);
        }

        if ($this->time_end) {
            $query->andFilterWhere(['<', 'log.created_at', strtotime($this->time_end)+86399]);
        }

        return $dataProvider;
    }
}
