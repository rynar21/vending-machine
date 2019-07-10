<?php

use yii\db\Migration;

/**
 * Class m190620_063311_store
 */
class m190620_063311_store extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('store',[
        'store_id'=>$this->primaryKey(),
        'store_name'=>$this->string()->notNull(),
        'store_address'=>$this->string()->notNull(),
        'store_contact'=>$this->string()->notNull(),
        'created_date' => $this->integer()->notNull(),
        'updated_date' => $this->integer()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('store');
        //echo "m190620_063311_store cannot be reverted.\n";
        //return false;
    }
}
