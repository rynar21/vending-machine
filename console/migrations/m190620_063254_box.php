<?php

use yii\db\Migration;

/**
 * Class m190620_063254_box
 */
class m190620_063254_box extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $this->createTable('box', [
              'id' => $this->primaryKey(),
              'code' => $this->string()->notNull(),
              'status' => $this->smallInteger()->notNull()->defaultValue(2),
              'created_at' => $this->integer()->notNull(),
              'updated_at' => $this->integer()->notNull(),
              'store_id' => $this->integer(),
          ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('box');
    }
}
