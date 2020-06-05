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

    //public $manager;
    public $username;//添加管理员

    public $imageFile;

    const STATUS_INITIAL = 0;  //初始状态0
    const STATUS_IN_OPERATION = 10; //运营中
    const STATUS_SUSPEND_BUSINESS = 9; //暂停营业
    const STATUS_IN_MAINTENANCE = 8; //维护中
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
            [['contact','user_id','status'], 'integer'],
            [['prefix','username',], 'safe'],
            [['name', 'address','description'], 'string', 'max' => 255],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['manager'],'safe'],
            [['contact'], 'trim'],
            ['contact','match','pattern'=>'/^[0][1][0-9]{8,9}$/'],
            ['contact', 'unique','message' => 'Phone number has been used'],
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
            'contact' => 'Mobile No.',
            'prefix' => 'Box Prefix',
            'manager' => 'Manager',
            'status' => 'Status',
        ];
    }

    public function getUser_name()
    {
        if (empty($this->user_id))
        {
            return '<span style="color:#CD0000">' .'Null'.'';
        }
        return $this->user->username;
    }

    //今日收益
    public function getProfit_today()
    {
        $total  = Store::STATUS_INITIAL;
        $models = SaleRecord::find()->where([
            'store_id' => $this->id,
            'status' => SaleRecord::STATUS_SUCCESS
        ])->andWhere([
            'between',
            'created_at' ,
            strtotime(date('Y-m-d', strtotime('0'.' day'))),
            strtotime(date('Y-m-d', strtotime('1'.' day')))
        ])->all();

        foreach ($models as $model )
        {
            $arr = $model->sell_price ;
            $total += $arr;
        }

        return $total;
    }

    //昨日收益
    public function getYesterday_earnings()
    {
        $total  = Store::STATUS_INITIAL;
        $models = SaleRecord::find()->where([
            'store_id' => $this->id,
            'status' => SaleRecord::STATUS_SUCCESS
        ])->andWhere([
            'between',
            'created_at' ,
            strtotime(date('Y-m-d', strtotime('-1'.' day'))),
            strtotime(date('Y-m-d', strtotime('0'.' day')))
        ])->all();

        foreach ($models as $model )
        {
            $arr = $model->sell_price ;
            $total += $arr;
        }

        return $total;
    }

    public function getTotal_sales_amount()
    {
        $total  = Store::STATUS_INITIAL;
        $models = SaleRecord::find()->where([
            'store_id' => $this->id,
            'status' => SaleRecord::STATUS_SUCCESS
        ])->all();

        foreach ($models as $model )
        {
            $arr = $model->sell_price ;
            $total += $arr;
        }

        return $total;
    }

    // Retrieve Items
    public function getItems()
    {
        return $this->hasMany(Item::className(), ['store_id'=>'id']);
    }

    // Retrieve Boxes
    public function getBoxes()
    {
        return $this->hasMany(Box::className(), ['store_id' => 'id']);
    }

    // 数据表 Image图片 属性
    public function getImageUrl()
    {
        if ($this->image )
        {
            return Yii::getAlias('@static/products/' . $this->image);
        }
        return Yii::getAlias('@static/products/product.jpg');
    }

    public function beforeSave($insert)
    {
        $this->imageFile = UploadedFile::getInstance($this, 'imageFile');
        if ($this->imageFile)
        {
            if ($this->image)
            {
                Yii::$app->s3->delete('products/' . $this->image);
            }

            $extension   = $this->imageFile->extension;
            $data        = $this->imageFile->tempName;
            $this->image = date('ymdHi') . '_' . uniqid() . '.' . $extension;

            Yii::$app->s3->upload('products/' . $this->image, $data, null, [
                'params' => [
                    'CacheControl' => 'public, max-age=31536000',
                ]
            ]);
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert,$changedAttributes)
    {
        return parent::afterSave($insert,$changedAttributes);
    }

    public  function getAddress()
    {
        return $this->address;
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
