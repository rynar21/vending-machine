<?php

use yii\db\Migration;

/**
 * Class m190620_063306_transaction
 */
class m190620_063306_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      $this->createTable('transaction',[
        'id' => $this -> primaryKey(),
        'details' => $this->string(),
        'created_at' => $this->integer()->notNull(),
        'updated_at' => $this->integer()->notNull(),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
      $this->dropTable('transaction');
        //echo "m190620_063306_transaction cannot be reverted.\n";
      //  return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063306_transaction cannot be reverted.\n";

        return false;
    }
    */
}
