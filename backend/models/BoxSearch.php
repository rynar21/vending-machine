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
    public $stu;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'code' , 'store_id'], 'integer'],
            [['status'], 'safe'],
            [['status','name'], 'trim'],
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


    public function search($params,$id)
    {
        $query = Box::find()->where(['box.store_id'=>$id]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query->orderBy(['id'=>SORT_ASC]),
            'pagination' => [
                'pageSize'=>30,
            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (strstr($this->status, 'A')||strstr($this->status, 'a')) {
            $this->stu = Box::BOX_STATUS_NOT_AVAILABLE;
        }
        if (strstr($this->status, 'N')||strstr($this->status, 'na')||strstr($this->status, 'n')) {
            $this->stu = Box::BOX_STATUS_AVAILABLE;
        }
        $query->andFilterWhere([
            'status' => $this->stu,
        ]);

        if ($this->name) {
            $query->joinWith('product');
        }
            $query->andFilterWhere(['like', 'product.name', $this->name])
            ->andFilterWhere(['code' => $this->code,]);
                // $query->andFilterWhere(['like', 'item.price', $this->price]);


        return $dataProvider;
    }



}
