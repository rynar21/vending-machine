<?php

use yii\db\Migration;
// use common\models\Box;

/**
 * Class box
 */
class box extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        $this->insert('box', [
            'id'            => 1,
            'code'          => 1,
            'status'        => 1,
            'created_at'    => "1584595153",
            'updated_at'    => "1584595153",
            'store_id'      => 1,
            'hardware_id'   => "01OK",
        ]);
    }

    // public function insert()
    // {
    //     $this->insert('box', [
    //         'id' => 1,
    //         'code' => 1,
    //         'status' => 1,
    //         'created_at' => "1584595153",
    //         'updated_at' => "1584595153",
    //         'store_id' => 1,
    //         'hardware_id' => "01OK",
    //     ]);
    // }

    // public function box_data($i)
    // {
    //     $model = new Box();
    //     $model->id = $i;
    //     $model->code = $i;
    //     $model->status = 1;
    //     $model->created_at = "1584595153";
    //     $model->updated_at = "1584595153";
    //     $model->store_id = 1;
    //     $model->hardware_id = "0". $i . "OK";
    //     $model->save();
    // }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('box');
    }
}
