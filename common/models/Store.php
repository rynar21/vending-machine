<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;


/**
 * This is the model class for table "store".
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property int $contact
 * @property string $created_at
 * @property string $updated_at
 */
class Store extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'store';
    }

    /**
     * {@inheritdoc}
     */
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
            [['name', 'address', 'contact'], 'required'],
            [['contact'], 'integer'],
            //[['contact'], 'validateContact'],
            //[['contact'],  'match', 'pattern'=>'/^[a-z]\w*$/i'],
            //[['contact'],  'match', 'pattern'=>'/^[\d]{10}$'],
            [['image'], 'default', 'value' => ''],
            [['name', 'address'], 'string', 'max' => 255],
            [['image'], 'default', 'value' => ''],
        ];
    }

    // public function validateContact($attribute, $params, $validator)
    // {
    //     if ($this->$attribute != '012') {
    //       $this->addError($attribute, 'Must be 012');
    //     }
    // }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Store ID',
            'name' => 'Store Name',
            'address' => 'Store Address',
            'contact' => 'Store Contact',
        ];
    }
    public function getItem()
    {
        return $this->hasOne(Item::className(),['id'=>'item_id']);
    }

    public function getBoxes()
    {
      return $this->hasMany(Box::className(), ['store_id' => 'id']);
    }

    public function getBoxes_count()
    {
        return $this->getBoxes()->count();
    }
}
