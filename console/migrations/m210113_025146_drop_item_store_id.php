<?php

use yii\db\Migration;

/**
 * Class m210113_025146_drop_item_store_id
 */
class m210113_025146_drop_item_store_id extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropColumn('item', 'store_id');
        $this->dropColumn('sale_record', 'store_name');
        $this->dropColumn('sale_record', 'item_name');
        $this->dropColumn('sale_record', 'box_code');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->addColumn('item', 'store_id', $this->integer());
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210113_025146_drop_item_store_id cannot be reverted.\n";

        return false;
    }
    */
}
