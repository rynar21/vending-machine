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
            'description'=>$this->string(),
            'address'=>$this->string()->notNull(),
            'contact'=>$this->string()->notNull(),
            'prefix' =>$this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'image'=>$this->string(),
            'user_id' => $this->integer(),
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
