<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
<<<<<<< Updated upstream
// use yii\helpers\BaseStringHelper;
=======
>>>>>>> Stashed changes

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property string $image
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class Product extends \yii\db\ActiveRecord
{
    public $imageFile;

    /**
     * {@inheritdoc}
     */
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


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'image'], 'required'],
            [['price'], 'number'],
<<<<<<< Updated upstream
            [['name', 'image'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
=======
            [['name'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => ture, 'extensions' => 'png, jpg'],
>>>>>>> Stashed changes
        ];
    }

    public function upload()
    {
        if ($this->validate()) {

            $this->image->saveAs('/C:\wamp64\www\cs\backend\image/' . $this->image->baseName . '.' . $this->image->extension);

            return true;
        } else {
            return false;
        }


    }

    /**
     * {@inheritdoc}
     */
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
      return $this->hasMany(Item::className(), ['product_id' => 'id']);
    }


    public function getImageUrl()
    {
        if (empty($this->image)) {
            return  '/mel-img/product.jpg';
        }

        return $this->image;
    }
}
