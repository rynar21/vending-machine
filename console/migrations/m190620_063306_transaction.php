<?php

use yii\db\Migration;

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

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190620_063306_transaction cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063306_transaction cannot be reverted.\n";

        return false;
    }
    */
}
