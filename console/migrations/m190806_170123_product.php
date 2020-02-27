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
          'sku'=>$this->string()->notNull(),
          'name'=>$this->string()->notNull(),
          'description'=>$this->string(),
          'category'=>$this->string()->notNull(),
          'price'=>$this->float(10,2)->notNull(),
          'cost'=>$this->string(),//
          'status' => $this->smallInteger()->notNull()->defaultValue(0),
          'image'=>$this->string(),//
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
