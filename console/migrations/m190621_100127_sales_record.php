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
        $this->createTable('sale_record', [
          'id' =>$this->primaryKey(),
          'order_number'=>$this->string()->notNull(),//
          'store_id' =>$this->integer()->notNull(),
          'box_id' =>$this->integer()->notNull(),
          'item_id' =>$this->integer()->notNull(),
          'sell_price' =>$this->float(10,2)->notNull(),
          'status' =>$this->smallInteger()->notNull(),
          'unique_id' =>$this->string()->notNull()->unique(),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'store_name'=>$this->string(255)->notNull(),
          'item_name'=>$this->string()->notNull(),
          'box_code'=>$this->string(20)->notNull(),
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
}
