<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\Url;

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
    public $imageFile;

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
            ['name', 'unique','message'=>'This storename has already been taken.'],
            [['name','address','user_id'], 'required',],
            [['contact'], 'integer'],
            ['contact', 'required'],
            ['contact', 'filter', 'filter' => 'trim'],
            ['contact','match','pattern'=>'/^[0][1][0-9]{8,9}$/'],
            ['contact', 'unique','message' => '手机号已被使用'],
            [['prefix','description'], 'safe'],
            [['name', 'address','description'], 'string', 'max' => 30],
            [['address'], 'string', 'max' => 60],
            [['description'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    // Labels for the Attributes
    public function attributeLabels()
    {
        return [
            'id' => 'Store ID',
            'name' => 'Store Name',
            // 'description'=>'Store Description'
            'address' => 'Store Address',
            'contact' => 'Store Contact',
            'prefix' => 'Box Prefix',
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

    // 数据表 Image图片 属性
    public function getImageUrl()
    {
        if ($this->image && file_exists(Yii::getAlias('@upload') . '/' . $this->image)) {
            return Url::to('@imagePath'). '/' . $this->image;
        }

        return Url::to('@imagePath'). '/store.jpg';
    }

    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($this->imageFile)
        {
            if ($this->image)
            {
                if (file_exists(Yii::getAlias('@upload') . '/' . $this->image))
                {
                    unlink(Yii::getAlias('@upload') . '/' . $this->image);
                }
                $this->image = time(). '_' . uniqid() . '.' . $this->imageFile->extension;
            }
            if ($this->image==null)
            {
                $this->image = time(). '_' . uniqid() . '.' . $this->imageFile->extension;
            }
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert,$changedAttributes)
    {
        if ($this->imageFile)
        {
            $path = Yii::getAlias('@upload') . '/' .$this->image;
            if (!empty($path))
            {
                $this->imageFile->saveAs($path, true);
            }
            // $this->imageFile->saveAs($path, true);
        }
        return parent::afterSave($insert,$changedAttributes);
    }
}
