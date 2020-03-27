<?php

use yii\db\Migration;
use common\models\Box;

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
          $this->createTable('box', [
              'id' => $this->primaryKey(),
              'code' => $this->string()->notNull(),
              'status' => $this->smallInteger()->notNull()->defaultValue(2),
              'created_at' => $this->integer()->notNull(),
              'updated_at' => $this->integer()->notNull(),
              'store_id' => $this->integer(),
              'hardware_id' => $this->string()
          ]);

          for ($i=1; $i < 7 ; $i++) {
              $this->box_data($i);
          }
    }

    public function box_data($i)
    {
        $model = new Box();
        $model->id = $i;
        $model->code = $i;
        $model->status = 1;
        $model->created_at = "1584595153";
        $model->updated_at = "1584595153";
        $model->store_id = 1;
        $model->hardware_id = "0". $i . "OK";
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('box');
    }
}
