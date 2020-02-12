<?php

namespace common\models;

use Yii;
use yii\base\Model;

class StorefinanceSearech extends Model
{
    public $store_id;
    public $date;
    //public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['id'], 'integer'],
            [['store_id', 'date'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'store_id' => 'store id',
            //'name' => 'Name',
            'date' => 'Date',
        ];
    }

     /**
     * @param $params
     * @return ArrayDataProvider
     */
    public function search($params)
    {
        $items = [
            ["id"=>1,"name"=>"Cyrus","email"=>"risus@consequatdolorvitae.org"],
            ["id"=>2,"name"=>"Justin","email"=>"ac.facilisis.facilisis@at.ca"],
            ["id"=>3,"name"=>"Mason","email"=>"in.cursus.et@arcuacorci.ca"],
            ["id"=>4,"name"=>"Fulton","email"=>"a@faucibusorciluctus.edu"]
        ];

        if ($this->load($params)) {
            $name = strtolower(trim($this->name));
            $items = array_filter($items, function ($role) use ($name) {
                return (empty($name) || strpos((strtolower(is_object($role) ? $role->name : $role['name'])), $name) !== false);
            });
        }

        $dataProvider = new ArrayDataProvider([
            'key'=>'id',
            'allModels' => $items,
            'pagination' => false, // 可选 不分页
            'sort' => [
                'attributes' => ['id', 'name', 'email'],
            ],
        ]);
    }
}
