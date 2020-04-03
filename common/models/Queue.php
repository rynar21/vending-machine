<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "queue".
 *
 * @property int $id
 * @property string $store_id
 * @property string|null $action
 * @property string|null $priority
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Queue extends \yii\db\ActiveRecord
{
    const STATUS_WAITING = 0;    //等待中
    const STATUS_SUCCESS = 1; //成功
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'queue';
    }
    // YII 自带时间值 功能
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            //[[ 'created_at', 'updated_at'], 'required'],
            [['store_id','status', 'created_at', 'updated_at'], 'integer'],
            [[ 'action', 'priority'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'action' => 'Action',
            'priority' => 'Priority',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }


    public static function push($store_id, $action, $priority=null)
    {
        $model = new Queue();
        $model->store_id    = $store_id;
        $model->action      = $action;
        $model->priority    = $priority;
        return $model->save();
    }
}
