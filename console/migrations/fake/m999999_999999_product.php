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
        $this->insert('product', [
            'id'            => 1, //$i,
            'sku'           => "ISBN 978-986-6248-06-1",//.$i,
            'name'          => "Kingston Pendrive", //$name_array[$i-1],
            'category'      => "Others",
            'description'   => "A good quality storage",
            'price'         => 2.00,
            'cost'          => 0.50,
            'status'        => 0,
            'image'         => "1.jpg", //$pic_array[$i-1];
            'created_at'    => "1584595153",
            'updated_at'    => "1584595153",
        ]);
    }

    // public function product_data($i){
    //     $model = new Product();
    //     $name_array = ['Kingston Pendrive', 'MicroSD Card', 'SkullCandy Headset',
    //                     '10000mAH PowerBank', 'BUM Watch', 'Pepsi'];
    //     $pic_array = ['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg'];
    //
    //
    //     $model->id = $i;
    //     $model->sku = "ISBN 978-986-6248-06-".$i;
    //     $model->name = $name_array[$i-1];
    //     $model->category = "Others";
    //     $model->description = "A good quality storage";
    //     $model->price = 2.00;
    //     $model->cost = 0.50;
    //     $model->status = 0;
    //     $model->image = $pic_array[$i-1];
    //     $model->created_at = "1584595153";
    //     $model->updated_at = "1584595153";
    //     $model->save();
    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

}
