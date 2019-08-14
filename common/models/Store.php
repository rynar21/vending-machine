<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\BaseArrayHelper;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

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
            [['name', 'address', 'contact'], 'required'],
            [['contact'], 'integer'],
            [['name', 'address'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
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

    // 数据表 Image图片 属性
    public function getImageUrl()
    {
        // 判断是否 Image属性 是否存在
        // 如果 Image属性 为空
        if (empty($this->image))
        {
            // 注入默认图片
            return  $this->image = 'store.jpg';
        }
        // 相反：返回 选择后图片的入境
        return $this->image;
    }

    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($this->imageFile==null) {
            $this->getImageUrl();
        }
        if ($this->imageFile) {
            if ($this->image) {

                 if (file_exists(Yii::getAlias('@upload') . '/' . $this->image)) {
                    unlink(Yii::getAlias('@upload') . '/' . $this->image);
                 }
                  $this->image = time(). '_' . uniqid() . '.' . $this->imageFile->extension;
            }
            if ($this->image==null) {
                  $this->image = time(). '_' . uniqid() . '.' . $this->imageFile->extension;
            }
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($this->imageFile) {
            $path = Yii::getAlias('@upload') . '/' . $this->image;
            $this->imageFile->saveAs($path, true);
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
