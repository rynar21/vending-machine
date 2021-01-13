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
        for ($i = 1; $i < 7 ; $i++) {
            $this->insert('item', [
                'id'          => $i,
                'price'       => 2.00,
                'status'      => 0,
                'created_at'  => "1584595153",
                'updated_at'  => "1584595153",
                'product_id'  => $i,
                'box_id'      => $i,
            ]);
        }

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('item');
    }
}
