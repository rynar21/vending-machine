<?php

use yii\db\Migration;


/**
 * Class m190620_063302_sales_record
 */
class m190620_063302_sales_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $this->createTable('sale_record', [
              'box_id' =>$this->integer()->notNull(),
              'item_id' =>$this->integer()->notNull(),
              'trans_id' =>$this->integer()->notNull(),
              'status' =>$this->smallInteger()->notNull()->defaultValue(10),
          ]);
    }


    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
            $this->dropTable('sale_record');
    }
}
