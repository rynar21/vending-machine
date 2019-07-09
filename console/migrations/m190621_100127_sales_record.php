<?php

use yii\db\Migration;

/**
 * Class m190621_100127_sales_record
 */
class m190621_100127_sales_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('sale_record');

        $this->createTable('sale_record', [
          'id' =>$this->primaryKey(),
          'box_id' =>$this->integer()->notNull(),
          'item_id' =>$this->integer()->notNull(),
          'trans_id' =>$this->integer()->notNull(),
          'status' =>$this->smallInteger()->notNull()->defaultValue(9),
          'created_date'=>$this->string()->notNull(),
          'updated_date'=>$this->string()->notNull(),
      ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          $this->dropTable('sale_record');

          $this->createTable('sale_record', [

              'box_id' =>$this->integer()->notNull(),
              'item_id' =>$this->integer()->notNull(),
              'trans_id' =>$this->integer()->notNull(),
              'status' =>$this->smallInteger()->notNull()->defaultValue(10),

          ]);
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190621_100127_sales_record cannot be reverted.\n";

        return false;
    }
    */
}
