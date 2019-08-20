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
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'address'=>$this->string()->notNull(),
            'contact'=>$this->string()->notNull(),
            'image'=>$this->string(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
          ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('store');
    }
}
