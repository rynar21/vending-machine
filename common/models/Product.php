<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
// use yii\helpers\BaseStringHelper;

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

<<<<<<< Updated upstream
    /**
     * {@inheritdoc}
     */
=======
    // 数据表 名称
>>>>>>> Stashed changes
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
            [['name', 'image'], 'string', 'max' => 255],
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

<<<<<<< Updated upstream
    // 搜索 对应产品的 Item产品
    public function getItems()
    {
      return $this->hasMany(Item::className(), ['product_id' => 'id']);
    }


    public function getImageUrl()
    {
        if (empty($this->image))
        {
            return  '/mel-img/product.jpg';
        }
=======
    // 数据表 Image图片 属性
    public function getImageUrl()
    {
        // 判断是否 Image属性 是否存在
        // 如果 Image属性 为空
        if (empty($this->image))
        {
            // 注入默认图片
            return  '/mel-img/product.jpg';
        }
        // 相反：返回 选择后图片的入境
>>>>>>> Stashed changes
        return $this->image;
    }

    public function upload_image()
    {
        $path = Yii::getAlias('@upload') . '/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
        $model->imageFile->saveAs($path, true);
    }
}
