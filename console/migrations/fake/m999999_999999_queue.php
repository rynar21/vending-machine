<?php

use yii\db\Migration;
use common\models\Queue;
use common\models\User;

/**
 * Class queue
 */
class m999999_999999_queue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->insert('queue',[
            'store_id'      => 1,
            'action'        => "01OK",
            'status'        => 0,
            'created_at'    => "1584595153",
            'updated_at'    => "1584595153",
       ]);
    }

    // public function queue_data()
    // {
    //     $model = new Queue();
    //     $model->store_id = 1;
    //     $model->action = "01OK";
    //     $model->status = 0;
    //     $model->created_at = "1584595153";
    //     $model->updated_at = "1584595153";
    //     $model->save();
    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('queue');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200227_075958_queue cannot be reverted.\n";

        return false;
    }
    */
}
