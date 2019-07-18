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
          'id' => $this->primaryKey(),
          'code' => $this->integer(),
          'status' => $this->smallInteger()->notNull()->defaultValue(2),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'store_id' => $this->integer(),
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
}
