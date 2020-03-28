<?php

use yii\db\Migration;

/**
 * Class m191011_031022_tbl_admin_session
 */
class m191011_031022_tbl_admin_session extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tbl_admin_session',[
          'session_id'=>$this->primaryKey(),
           'id' =>$this->integer()->notNull(),
          'session_token'=>$this->string()->notNull(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // echo "m191011_031022_tbl_admin_session cannot be reverted.\n";
        //
        // return false;
        $this->dropTable('tbl_admin_session');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_031022_tbl_admin_session cannot be reverted.\n";

        return false;
    }
    */
}
