<?php

use yii\db\Migration;

/**
 * Class m200207_020710_finance
 */
class m200207_020710_finance extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->createTable('finance',[
        'id' =>$this->primaryKey(),
        'date'=>$this->string()->notNull(),
        'quantity_of_order'=>$this->integer()->notNull(),//订单数量
        'total_earn'=>$this->float(10,2)->notNull(),//总收入
        'gross_profit'=>$this->float(10,2)->notNull(),//毛利润
        'net_profit'=>$this->float(10,2)->notNull(),//纯利润
        'created_at' =>$this->integer()->notNull(),
        'updated_at' =>$this->integer()->notNull(),
    ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('finance');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200207_020710_finance cannot be reverted.\n";

        return false;
    }
    */
}
