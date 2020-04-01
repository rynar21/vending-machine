<?php

use yii\db\Migration;
// use common\models\Store;

/**
 * Class store
 */
class store extends Migration
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

    // public function store_data()
    // {
    //     $store = new Store();
    //     $store->id = 1;
    //     $store->name = "Ashchaser shd. bhd";
    //     $store->description = "The company is began on 2019. Invented all kind of mask for user";
    //     $store->address = "No.7 lot 1095, Paradise Garden 9th Mile, 93250 Kuching";
    //     $store->contact = "0165253276";
    //     $store->prefix = "A";
    //     $store->status = 10;
    //     $store->user_id = 1;
    //     $store->created_at = "1584595153";
    //     $store->updated_at = "1584595153";
    //     $store->save();
    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('store');
    }
}
