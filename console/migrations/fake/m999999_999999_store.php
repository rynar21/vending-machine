<?php

use yii\db\Migration;
// use common\models\Store;

/**
 * Class store
 */
class m999999_999999_store extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('store',[
            'id' => 1,
            'name' => "Rynar Ashchaser sdn. Bhd.",
            'description' => "The company is began on 2019. Invented all kind of mask for user",
            'address' => "No.7 lot 1095, Paradise Garden 9th Mile, 93250 Kuching",
            'contact' => "0165253276",
            'prefix' => "A",
            'status' => 10,
            'user_id' => 1,
            'created_at' => "1584595153",
            'updated_at' => "1584595153",
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('store');
    }
}
