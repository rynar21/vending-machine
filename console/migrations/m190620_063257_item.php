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
        'box_id'=>$this->integer()->notNull(),
        'created_date' => $this->integer()->notNull(),
        'updated_date' => $this->integer()->notNull(),
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
