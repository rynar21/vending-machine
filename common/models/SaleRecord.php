<?php
// SaleRecord交易订单 信息 数据表
// last Modified: 04/08/2019
namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "sale_record".
 * @property int $id
 * @property int $box_id
 * @property int $item_id
 * @property int $status
 */
class SaleRecord extends \yii\db\ActiveRecord
{
    // 交易订单 状态
    const STATUS_PENDING = 9;    //购买中
    const STATUS_SUCCESS = 10;   //购买成功
    const STATUS_FAILED = 8;  //购买失败

    // 数据表名称
    public static function tableName()
    {
        return 'sale_record';
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
            [['box_id', 'item_id'], 'required'],
            [['box_id', 'item_id'], 'integer'],
            [['sell_price'], 'number'],
            [['status'], 'default', 'value' => self::STATUS_PENDING],
        ];
    }

    // 数据表 属性 标志
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'store_id' => 'Store ID',
            'box_id' => 'Box ID',
            'item_id' => 'Item ID',
            'status' => 'Status',
            'sell_price' => 'Price',
        ];
    }

    // 寻找 Item产品 数据表
    public function getItem()
    {
        return $this->hasOne(Item::className(), ['id' => 'item_id']);
    }

    // 寻找 Box盒子 数据表
    public function getBox()
    {
        return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    public function getStore()
    {
        return $this->hasOne(Store::className(), ['id' => 'store_id']);
    }

    public function getPricing()
    {
        $num = number_format($this->sell_price, 2);
        return 'RM '.$num;
    }

    // 更新 对应的数据表里的 属性
    // 交易状态： 购买当中
    public function pending()
    {
        if ($this->status !=SaleRecord::STATUS_SUCCESS && $this->status !=SaleRecord::STATUS_FAILED)
        {
           // 更新 Item产品 的状态属性 为购买当中
           $this->status=SaleRecord::STATUS_PENDING;
           $this->save();
           $this->item->status = Item::STATUS_LOCKED;
           $this->item->save();
        }
        return $this->save() && $this->item->save();
    }

    // 交易状态：购买成功
    public function success()
    {
        if ($this->status == SaleRecord::STATUS_PENDING)
        {
            $this->status = SaleRecord::STATUS_SUCCESS;
            $this->save();
            // 更新 Item产品 的状态属性 为购买成功
            $this->item->status = Item::STATUS_SOLD;
            $this->item->save();
            // 更新 Box盒子 的状态属性 为空
            $this->box->status = Box::BOX_STATUS_AVAILABLE;
            $this->box->save();
         }
         return $this->save() && $this->item->save() && $this->box->save() &&
         $this->curlPost([
             'data'=>[
                 // 'text'=>implode([
                 //     'Store name'=>$this->store->name,
                 //     'Address'=>$this->store->address,
                 //     'Transaction ID'=>$this->id,
                 //     'Purchased Time'=>$this->updated_at,
                 //     'Box'=>$this->box->code,
                 //     'Item'=>$this->item->name,
                 // ]),
                 // 'message'=>[
                 //     'Store name'=>$this->store->name,
                 //     'Address'=>$this->store->address,
                 //     'Transaction ID'=>$this->id,
                 //     'Purchased Time'=>$this->updated_at,
                 //     'Box'=>$this->box->code,
                 //     'Item'=>$this->item->name,
                 // ],
                 'text'=>'Store name'.':'.$this->store->name.','.
                         'Address'.':'.$this->store->address.','.
                         'Transaction ID'.':'.$this->id.','.
                         'Purchased Time'.':'.$this->updated_at.','.
                         'Box'.':'.$this->box->code.','.
                         'Item'.':'.$this->item->name,
             ],
             // 'url'=>'https://pcl.requestcatcher.com',
         ]);
    }

    public function curlPost($config)
    {
        $url = ArrayHelper::getValue($config, 'url', 'https://hooks.slack.com/services/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');
        $data = ArrayHelper::getValue($config, 'data', ['text'=>'Hello, World!']);
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//设置提交的字符串
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        //1 检查服务器SSL证书中是否存在一个公用名(common name).公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。2 检查公用名是否存在，并且是否与提供的主机名匹配。
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
    }

    // 交易状态： 购买失败
    public function failed()
    {
        if ($this->status == SaleRecord::STATUS_PENDING)
        {
            // 更新 Item产品 的状态属性 为购买失败/初始值
            $this->status = SaleRecord::STATUS_FAILED;
            $this->save();

            if ($this->item->status != Item::STATUS_SOLD)
            {
                $this->item->status = Item::STATUS_AVAILABLE;
                $this->item->save();
            }
        }
        return $this->save() && $this->item->save();
    }

}
