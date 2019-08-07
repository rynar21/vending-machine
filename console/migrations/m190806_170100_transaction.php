<?php

use yii\db\Migration;

/**
 * Class m190806_170100_transaction
 */
class m190806_170100_transaction extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
         $this->dropTable('transaction');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }
}
