<?php

use yii\db\Migration;


/**
 * Class m200227_075958_queue
 */
class m200227_075958_queue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('queue',[
           'id' => $this->primaryKey(),
           'store_id'=> $this->integer()->notNull(),
           'action' => $this->string(),
           'priority' => $this->string(),
           'status' => $this->smallInteger()->notNull()->defaultValue(0),
           'created_at' => $this->integer()->notNull(),
           'updated_at' => $this->integer()->notNull(),
       ]);


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('queue');
    }


    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200227_075958_queue cannot be reverted.\n";

        return false;
    }
    */
}
