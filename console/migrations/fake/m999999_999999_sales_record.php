<?php

use yii\db\Migration;
use common\models\SaleRecord;
/**
 * Class sales_record
 */
class m999999_999999_sales_record extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('sale_record',[
        'id' => 1,
        'order_number' = uniqid(),
        'store_id' = 1,
        'box_id' = 17,
        'item_id' = 17,
        'sell_price' = 2.00,
        'unique_id' = uniqid(),
        'created_at' = "1584595153",
        'updated_at' = "1584595153",
        'store_name' = "Rynar Ashchaser shd. bhd",
        'item_name' = "N95 Mask",
        'box_code' = 17,
        'status' = 10,
      ]);
    }

    // public function sale_data()
    // {
    //     $model = new SaleRecord();
    //     $model->id = 1;
    //     $model->order_number = uniqid();
    //     $model->store_id = 1;
    //     $model->box_id = 99;
    //     $model->item_id = 99;
    //     $model->sell_price = 2.00;
    //     $model->unique_id = uniqid();
    //     $model->created_at = "1584595153";
    //     $model->updated_at = "1584595153";
    //     $model->store_name = "Rynar Ashchaser shd. bhd";
    //     $model->item_name = "N95 Mask";
    //     $model->box_code = 99;
    //     $model->status = 10;
    //     $model->save();
    // }

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
