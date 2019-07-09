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
        'created_date'=>$this->DateTime()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('item');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063257_item cannot be reverted.\n";

        return false;
    }
    */
}
