<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property string $image
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFile;

    public static function tableName()
    {
        return 'product';
    }

    // YII 自带时间值 功能
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    // 数据表 属性 规则
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['price'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
        ];
    }

    // 数据表 属性 标注
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'price' => 'Price',
            'image' => 'Image',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    // 数据表 Image图片 属性
    public function getImageUrl()
    {
        // 判断是否 Image属性 是否存在
        // 如果 Image属性 为空
        if (empty($this->image))
        {
            $this->image = 'product.jpg';
            // 注入默认图片
            return $this->image;
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
