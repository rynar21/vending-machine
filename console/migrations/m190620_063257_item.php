<?php

use yii\db\Migration;

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
        'name'=>$this->string()->notNull(),
        'price'=>$this->float(10,2)->notNull(),
        'image'=>$this->string()->notNull(),
        'status' =>$this->smallInteger()->notNull(),
        'created_at' =>$this->integer()->notNull(),
        'updated_at' =>$this->integer()->notNull(),
        'box_id'=>$this->integer()->notNull(),
        'store_id'=>$this->integer()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }
}
