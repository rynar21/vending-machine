<?php

use yii\db\Migration;

/**
 * Class m190806_154348_transaction
 */
class m190806_154348_transaction extends Migration
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
