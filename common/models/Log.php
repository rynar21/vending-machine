<?php

namespace common\models;
use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * This is the model class for table "log".
 *
 * @property int $id
 * @property int $user_id
 * @property string $type
 * @property string $action
 * @property string|null $data_json
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Log extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'log';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'type', 'action',], 'required'],
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['data_json'], 'string'],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['type', 'action'], 'string', 'max' => 255],
        ];
    }

    public function getTypes()
    {
        $models = self::find()->all();

        $data[''] = 'All';
        foreach ($models as $model) {
            $data[$model->type] = $model->type;
              
        }

        return $data;
    }

    public function getActions()
    {
        $models = self::find()->all();

        $data[''] = 'All';
        foreach ($models as $model) {
            $data[$model->action] = $model->action;
              
        }

        return $data;
    }

    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'action' => 'Action',
            'data_json' => 'Data Json',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * To push an audit log
     *
     * @property int $user_id User ID
     * @property string $type
     * @property string $action
     * @property array $message ...
     *
     * @return boolean
     */
    static function push($user_id, $type, $action, $message=null)
    {
        $model = new Log();
        $model->user_id = $user_id;
        $model->type = $type;
        $model->action = $action;

        $data_json  = [];
        $message['operating_time'] = date('Y-m-d H:i:s',time());
        $data_json['message'] = $message;
        $model->data_json = Json::encode($data_json);

        $model->save();
    }
}
