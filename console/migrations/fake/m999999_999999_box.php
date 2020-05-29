<?php

use yii\db\Migration;
// use common\models\Box;

/**
 * Class box
 */
class m999999_999999_box extends Migration
{
    /**
     * {@inheritdoc}
     */

    public function safeUp()
    {
        for ($i = 1; $i < 7; $i++)
        {
            $this->insert('box', [
                'id'            => $i,
                'code'          => $i,
                'status'        => 1,
                'created_at'    => "1584595153",
                'updated_at'    => "1584595153",
                'store_id'      => 1,
                'hardware_id'   => "0". $i ."OK",
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->truncateTable('box');
    }
}
