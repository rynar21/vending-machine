<?php

use yii\db\Migration;

/**
 * Class m190806_170123_product
 */
class m190806_170123_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('product',[
          'id'=>$this->primaryKey(),
          'name'=>$this->string()->notNull(),
          'price'=>$this->float(10,2)->notNull(),
          'image'=>$this->string(),
          'status' =>$this->smallInteger()->notNull(),
          'created_at' =>$this->integer()->notNull(),
          'updated_at' =>$this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('product');
    }

}
