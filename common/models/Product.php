<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;

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
    public $oldimage;

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

    // 搜索 对应产品的 Item产品
    public function getItems()
    {
      return $this->hasone(Item::className(), ['product_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($this->imageFile && $this->image) {
            if (file_exists( Yii::getAlias('@upload') . '/'. $this->image ) &&  $this->image!='product.jpg') {
                 unlink( Yii::getAlias('@upload') . '/'. $this->image );
             }
             $this->image = time() .'_'. uniqid(). '.' . $this->imageFile->extension;
        }
        // $this->image = time() .'_'. uniqid(). '.' . $this->imageFile->extension;
        if ($this->imageFile==null) {
            return $this->image='product.jpg';
        }
        return parent::beforeSave($insert);
    }
    public function afterSave($insert,$changedAttributes)
    {
        if ($this->imageFile) {
            $path = Yii::getAlias('@upload') . '/' .$this->image;
            if (!empty($path)) {
                $this->imageFile->saveAs($path, true);
            }
            // $this->imageFile->saveAs($path, true);
        }
        return parent::afterSave($insert,$changedAttributes);
    }
    //
    ///上传/修改图片
    ///
    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');

        if ($this->imageFile) {
            if ($this->image) {
                    if (file_exists(Yii::getAlias('@upload') . '/' . $this->image)) {
                        if ($this->image!='$oldimage') {
                            unlink(Yii::getAlias('@upload') . '/' . $this->image);
                        }
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
