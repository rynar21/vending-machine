<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseArrayHelper;
use yii\helpers\ArrayHelper;


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
    public $text= '/mel-img/store.jpg';

    // Table Name
    public static function tableName()
    {
        return 'store';
    }

    // Implement Yii TimestampBehavior
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    // Rules for the Attributes
    public function rules()
    {
        return [
            [['name', 'address', 'contact'], 'required'],
            [['contact'], 'integer'],
            [['image'], 'default', 'value' => ''],
            [['name', 'address'], 'string', 'max' => 255],
        ];
    }

    // Labels for the Attributes
    public function attributeLabels()
    {
        return [
            'id' => 'Store ID',
            'name' => 'Store Name',
            'address' => 'Store Address',
            'contact' => 'Store Contact',
        ];
    }

    // Retrieve Items
    public function getItems()
    {
        return $this->hasMany(Item::className(),['store_id'=>'id']);
    }

    // Retrieve Boxes
    public function getBoxes()
    {
      return $this->hasMany(Box::className(), ['store_id' => 'id']);
    }

    // public function getImage()
    // {
    //     if($this->image = '')
    //     {
    //         $this->image = '/mel-img/store.jpg';
    //         $this->save();
    //     }
    //     return $this->image;
    //
    //     //return $this->image = ArrayHelper::getValue($this, 'image', 'text');
    // }
}
