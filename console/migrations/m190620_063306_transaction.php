<?php

use yii\db\Migration;
use yii\db\Schema;

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
        if($this->db->schema->getTableSchema('transaction',true))
        {
            $this->dropTable('transaction');
        }
    }
}
