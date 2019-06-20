<?php

use yii\db\Migration;

/**
 * Class m190620_063249_operator
 */
class m190620_063249_operator extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('operator', [
            // 'id' => $this->primaryKey(),
            // 'name' => $this->string()->notNull()->unique(),
            // 'remark' => $this->text(),
            //
            // 'status' => $this->smallInteger()->notNull()->defaultValue(10),
            // 'created_at' => $this->integer()->notNull(),
            // 'updated_at' => $this->integer()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('operator');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063249_operator cannot be reverted.\n";

        return false;
    }
    */
}
