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
      //   $this->insert('sale_record',[
      //   'id' => 1,
      //   'order_number' => uniqid(),
      //   'store_id' => 1,
      //   'box_id' => 17,
      //   'item_id' => 17,
      //   'sell_price' => 2.00,
      //   'unique_id' => uniqid(),
      //   'created_at' => "1584595153",
      //   'updated_at' => "1584595153",
      //   'store_name' => "Rynar Ashchaser shd. bhd",
      //   'item_name' => "N95 Mask",
      //   'box_code' => 17,
      //   'status' => 10,
      // ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('sale_record');
    }
}
