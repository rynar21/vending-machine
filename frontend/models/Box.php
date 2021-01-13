<?php

namespace frontend\models;

use Yii;

class Box extends \common\models\Box
{
    public function fields()
    {
        return [
            'id' => function() {
                return $this->getItemId();
            },
            'amount' => function() {
                return $this->getItemPrice();
            },
            'image' => function() {
                return $this->getItemImageUrl();
            },
            'name' => function() {
                return $this->item->name;
            },
            'code' => function() {
                return $this->getBoxcode();
            },
        ];
    }
}
