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
    public $username;
    public $imageFile;
    //初始0
    const STATUS_INITIAL = 0;
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
            [['name', 'address', 'contact',], 'required'],
            [['contact','user_id'], 'integer'],
            [['prefix','username'], 'safe'],
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
            'prefix' => 'Box Prefix',
        ];
    }

    public function getUser()
    {
        if (empty($this->user_id)) {
            return '<span style="color:#CD0000">' .'Null'.'';
        }
        return user::find()->where(['id'=>$this->user_id])->one()->username;
    }
    //今日收益
    public function getProfit_today()
    {
        $total = Store::STATUS_INITIAL;
        $model1 = SaleRecord::find()->where(['store_id'=>$this->id,'status'=>10])
        ->andWhere([
            'between',
            'created_at' ,
            strtotime(date('Y-m-d',strtotime('0'.' day'))),
            strtotime(date('Y-m-d',strtotime('1'.' day')))
        ])
        ->all();
        foreach ($model1 as $model ) {
        $arr = $model->sell_price ;
        $total += $arr;
        }
        return $total;
    }
    //昨日收益
    public function getYesterday_earnings()
    {
        $total = Store::STATUS_INITIAL;
        $model1 = SaleRecord::find()->where(['store_id'=>$this->id,'status'=>10])
        ->andWhere([
            'between',
            'created_at' ,
            strtotime(date('Y-m-d',strtotime('-1'.' day'))),
            strtotime(date('Y-m-d',strtotime('0'.' day')))
        ])
        ->all();
        foreach ($model1 as $model ) {
        $arr = $model->sell_price ;
        $total += $arr;
        }
        return $total;
    }

    public function getTotal_sales_amount()
    {
        $total = Store::STATUS_INITIAL;
        $model1 = SaleRecord::find()->where(['store_id'=>$this->id,'status'=>10])->all();
        foreach ($model1 as $model ) {
        $arr = $model->sell_price ;
        $total += $arr;
        }
        return $total;
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
