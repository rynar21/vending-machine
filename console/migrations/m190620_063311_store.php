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
        'store_contact'=>$this->integer()->notNull(),
        'store_image'=>$this->string()->notNull(),
        'created_date'=>$this->string()->notNull(),
        'updated_date'=>$this->string()->notNull(),
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

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063311_store cannot be reverted.\n";

        return false;
    }
    */
}
