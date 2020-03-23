<?php
use yii\db\Migration;
use common\models\Store;
use common\models\User;


class fake_data extends Migration
{
    public function safeUp(){
        $store = new Store();
        $store->name = "Ashchaser shd. bhd";
        $store->description = "The company is began on 2019. Invented all kind of mask for user";
        $store->address = "No.7 lot 1095, Paradise Garden 9th Mile, 93250 Kuching";
        $store->contact = "0165253276";
        $store->prefix = "V";
        $store->user_id = 1;
        $store->created_at = "1584595153";
        $store->updated_at = "1584595153";
        $store->save();

        // return $store->save();
    }

    public function safeDown()
    {
        $this->dropTable('fake_data');
    }

}
 ?>
