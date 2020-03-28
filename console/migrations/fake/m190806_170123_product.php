<?php

use yii\db\Migration;
use common\models\Product;

/**
 * Class m190806_170123_product
 */
class m190806_170123_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product',[
          'id'=>$this->primaryKey(),
          'sku'=>$this->string()->notNull(),
          'name'=>$this->string()->notNull(),
          'category'=>$this->string()->notNull(),
          'description'=>$this->string(),
          'price'=>$this->float(10,2)->notNull(),
          'cost'=>$this->float(10,2),
          'status' => $this->smallInteger()->notNull()->defaultValue(0),
          'image'=>$this->string(),//
          'created_at' =>$this->integer()->notNull(),
          'updated_at' =>$this->integer()->notNull(),
        ]);

        for ($i=1; $i < 7 ; $i++)
        {
            $this->product_data($i);
        }
    }

    public function product_data($i){
        $model = new Product();
        $name_array = ['Kingston Pendrive', 'MicroSD Card', 'SkullCandy Headset',
                        '10000mAH PowerBank', 'BUM Watch', 'Pepsi'];
        $pic_array = ['1.jpg','2.jpg','3.jpg','4.jpg','5.jpg','6.jpg'];


        $model->id = $i;
        $model->sku = "ISBN 978-986-6248-06-".$i;
        $model->name = $name_array[$i-1];
        $model->category = "Others";
        $model->description = "A good quality storage";
        $model->price = 2.00;
        $model->cost = 0.50;
        $model->status = 0;
        $model->image = $pic_array[$i-1];
        $model->created_at = "1584595153";
        $model->updated_at = "1584595153";
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

}
