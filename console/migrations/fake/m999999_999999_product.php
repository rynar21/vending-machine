<?php

use yii\db\Migration;
use common\models\Product;

/**
 * Class product
 */
class m999999_999999_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $name_array = ['Kingston Pendrive', 'MicroSD Card', 'SkullCandy Headset',
                        '10000mAH PowerBank', 'BUM Watch', 'Pepsi'];
        $pic_array = ['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg'];

        for ($i=1; $i < 7 ; $i++) {
            $this->insert('product', [
                'id'            => $i,
                'sku'           => "ISBN 978-986-6248-06-" . $i,
                'name'          => $name_array[$i-1],
                'category'      => "Others",
                'description'   => "A good quality storage",
                'price'         => 2.00,
                'cost'          => 0.50,
                'status'        => 0,
                'image'         => $pic_array[$i-1],
                'created_at'    => "1584595153",
                'updated_at'    => "1584595153",
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('product');
    }

}
