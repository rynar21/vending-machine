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
            // [['status'], 'safe'],
            [['name'], 'safe'],
            [['price'], 'number'],
            [['status'], 'filter', 'filter' => function($text)
            {
                switch ($text)
                {
                    case 'Available':
                    case 'available':
                        $this->status = 1;
                        break;

                    case 'Not Available':
                    case 'not available':
                        $this->status = 2;
                        break;

                    default:
                        break;
                }
                return $this->status;
            }],
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


    public function search($params,$id)
    {
        $query = Box::find()->where(['box.store_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            // 'pagination' =>['pageSize'=>20]
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        // $query->andFilterWhere([
        //     'product.name' => $this->name,
        // ]);

        if ($this->name) {
            $query->joinWith('product');
        }
            $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['status'=>$this->status]);
            // $query->andFilterWhere(['like', 'item.price', $this->price]);


        return $dataProvider;
    }



}
