<?php

namespace backend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Store;
use common\models\Item;
use Yii;

/**
 * StoreSearch represents the model behind the search form of `common\models\Store`.
 */
class StoreSearch extends Store
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'address'], 'string'],
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
        if ( Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id,'staff'))
        {
            $query = Store::find();
        }
        else
        {
            $query = Store::find()->where(['user_id'=>Yii::$app->user->identity->id]);
        }
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
        $query->andFilterWhere(['id' => $this->id, 'contact' => $this->contact])
            // ->andFilterWhere(['like', 'contact', $this->contact,])
            ->andFilterWhere(['like', 'name', $this->name,])
            ->andFilterWhere(['like', 'address', $this->address,]);

        return $dataProvider;
    }
}
