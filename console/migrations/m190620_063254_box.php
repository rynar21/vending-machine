<?php

use yii\db\Migration;

/**
 * Class m190620_063254_box
 */
class m190620_063254_box extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
      // $authManager = $this->getAuthManager();
      // $this->db = $authManager->db;
      // $tableOptions = null;
      // if($this->db->driverName === 'mysql'){
      //   $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
      // }
      $this->createTable('box', [
          'box_id' => $this->primaryKey(),
          'box_code' => $this->integer(),
          'box_status' => $this->smallInteger()->notNull()->defaultValue(0),
      ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('box');
        // echo "m190620_063254_box cannot be reverted.\n";
        // return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190620_063254_box cannot be reverted.\n";

        return false;
    }
    */
}
