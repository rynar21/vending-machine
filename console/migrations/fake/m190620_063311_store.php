<?php

use yii\db\Migration;
use common\models\Store;

/**
 * Class m190620_063311_store
 */
class m190620_063311_store extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
          $this->createTable('store',[
            'id'=>$this->primaryKey(),
            'name'=>$this->string()->notNull(),
            'description'=>$this->string(),
            'address'=>$this->string()->notNull(),
            'contact'=>$this->string()->notNull(),
            'prefix' =>$this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'image'=>$this->string(),
            'user_id' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
          ]);
          $this->store_data();
          // return $store->save();
    }

    public function store_data()
    {
        $store = new Store();
        $store->id = 1;
        $store->name = "Ashchaser shd. bhd";
        $store->description = "The company is began on 2019. Invented all kind of mask for user";
        $store->address = "No.7 lot 1095, Paradise Garden 9th Mile, 93250 Kuching";
        $store->contact = "0165253276";
        $store->prefix = "A";
        $store->status = 10;
        $store->user_id = 1;
        $store->created_at = "1584595153";
        $store->updated_at = "1584595153";
        $store->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('store');
    }
}
