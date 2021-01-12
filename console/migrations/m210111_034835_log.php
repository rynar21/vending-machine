<?php

use yii\db\Migration;

/**
 * Class m210111_034835_log
 */
class m210111_034835_log extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log', [
            'id'                => $this->primaryKey(),
            'user_id'           => $this->integer()->notNull(),
            'type'              => $this->string()->notNull(),
            'action'            => $this->string()->notNull(),
            'data_json'         => $this->text(),
            'status'            => $this->integer()->notNull(),
            'created_at'        => $this->integer()->notNull(),
            'updated_at'        => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('log');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210111_034835_log cannot be reverted.\n";

        return false;
    }
    */
}
