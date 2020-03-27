<?php

use yii\db\Migration;
use common\models\Item;

/**
 * Class m190620_063257_item
 */
class m190620_063257_item extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $this->createTable('item',[
            'id'=>$this->primaryKey(),
            'price'=>$this->float(10,2)->notNull(),
            'status' =>$this->smallInteger()->notNull(),
            'created_at' =>$this->integer()->notNull(),
            'updated_at' =>$this->integer()->notNull(),
            'product_id'=>$this->integer()->notNull(),
            'box_id'=>$this->integer()->notNull(),
            'store_id'=>$this->integer()->notNull(),
          ]);
          for ($i=1; $i < 7; $i++)
          {
              $this->item_data($i);
          }
    }

    public function item_data($i)
    {
        $model = new Item();

        $model->id          = $i;
        $model->price       = 2.00;
        $model->status      = 0;
        $model->created_at  = "1584595153";
        $model->updated_at  = "1584595153";
        $model->product_id  = $i;
        $model->box_id      = $i;
        $model->store_id    = 1;
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }
}
