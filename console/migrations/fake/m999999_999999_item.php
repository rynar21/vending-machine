<?php

use yii\db\Migration;
use common\models\Item;

/**
 * Class item
 */
class m999999_999999_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('item', [
            'id'          => 1,
            'price'       => 2.00,
            'status'      => 0,
            'created_at'  => "1584595153",
            'updated_at'  => "1584595153",
            'product_id'  => 1,
            'box_id'      => 1,
            'store_id'    => 1,
        ]);
    }

    // public function item_data($i)
    // {
    //     $model = new Item();
    //
    //     $model->id          = $i;
    //     $model->price       = 2.00;
    //     $model->status      = 0;
    //     $model->created_at  = "1584595153";
    //     $model->updated_at  = "1584595153";
    //     $model->product_id  = $i;
    //     $model->box_id      = $i;
    //     $model->store_id    = 1;
    //     $model->save();
    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }
}
