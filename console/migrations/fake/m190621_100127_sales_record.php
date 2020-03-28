<?php

use yii\db\Migration;
use common\models\SaleRecord;
/**
 * Class m190621_100127_sales_record
 */
class m190621_100127_sales_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->dropTable('sale_record');

        $this->createTable('sale_record', [
          'id' =>$this->primaryKey(),
          'order_number'=>$this->string(20)->notNull(),//
          'store_id' =>$this->integer()->notNull(),
          'box_id' =>$this->integer()->notNull(),
          'item_id' =>$this->integer()->notNull(),
          'sell_price' =>$this->float(10,2)->notNull(),
          'status' =>$this->smallInteger()->notNull(),
          'unique_id' =>$this->string(20)->notNull()->unique(),
          'created_at' => $this->integer()->notNull(),
          'updated_at' => $this->integer()->notNull(),
          'store_name'=>$this->string(255)->notNull(),
          'item_name'=>$this->string(50)->notNull(),
          'box_code'=>$this->string(20)->notNull(),
      ]);
      $this->sale_data();
    }

    public function sale_data()
    {
        $model = new SaleRecord();
        $model->id = 1;
        $model->order_number = uniqid();
        $model->store_id = 1;
        $model->box_id = 1;
        $model->item_id = 1;
        $model->sell_price = 2.00;
        $model->unique_id = uniqid();
        $model->created_at = "1584595153";
        $model->updated_at = "1584595153";
        $model->store_name = "Rynar Ashchaser shd. bhd";
        $model->item_name = "N95 Mask";
        $model->box_code = 1;
        $model->status = 10;
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
          $this->dropTable('sale_record');

          $this->createTable('sale_record', [
              'box_id' =>$this->integer()->notNull(),
              'item_id' =>$this->integer()->notNull(),
              'trans_id' =>$this->integer()->notNull(),
              'status' =>$this->smallInteger()->notNull()->defaultValue(10),
          ]);
    }
}
