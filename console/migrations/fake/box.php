<?php

use yii\db\Migration;
use common\models\Box;

/**
 * Class m190620_063254_box
 */
class box extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        for ($i=1; $i < 7 ; $i++)
        {
            $this->box_data($i);
        }
    }

    public function box_data($i)
    {
        $model = new Box();
        $model->id = $i;
        $model->code = $i;
        $model->status = 1;
        $model->created_at = "1584595153";
        $model->updated_at = "1584595153";
        $model->store_id = 1;
        $model->hardware_id = "0". $i . "OK";
        $model->save();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('box');
    }
}
