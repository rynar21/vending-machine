<?php

namespace common\models;

use Yii;
use common\models\SaleRecord;
use common\models\Store;
use common\models\Item;
use common\models\Product;
use common\models\User;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "finance".
 *
 * @property int $id
 * @property string $date
 * @property int $quantity_of_order
 * @property float $total_earn
 * @property float $gross_profit
 * @property float $net_profit
 * @property int $created_at
 * @property int $updated_at
 */
class Finance extends \yii\db\ActiveRecord
{
    const FINANCE_ININIAL_VALUE = 0;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'finance';
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
            [['date', 'quantity_of_order', 'total_earn', 'gross_profit', 'net_profit'], 'required'],
            [['quantity_of_order', 'created_at', 'updated_at'], 'integer'],
            [['total_earn', 'gross_profit', 'net_profit'], 'number'],
            [['date'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'date' => 'Date',
            'quantity_of_order' => 'Quantity Of Order',
            'total_earn' => 'Total Earn',
            'gross_profit' => 'Gross Profit',
            'net_profit' => 'Net Profit',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function array_unique_fb($array2D)
    {

        foreach ($array2D as $v)
        {
            $v = join(',', $v); //降维,也可以用implode,将一维数组转换为用逗号连接的字符串
            $temp[] = $v;
        }

        $temp = array_unique($temp);
         //去掉重复的字符串,也就是重复的一维数组
        foreach ($temp as $k => $v)
        {
            $temp[$k] =  array(
                'store_id' => explode(',', $v)[0] ,
                'date' => explode(',', $v)[1] //再将拆开的数组重新组装
            );
        }

        return $temp;

    }

    public static function find_store_one_finance_oneday($id, $date)
    {
        $store = Store::find()->where(['id' => $id])->one();

        $total      =  Store::STATUS_INITIAL;
        $cost_price =  Store::STATUS_INITIAL;

        $records = SaleRecord::find()->where(['store_id' => $id])
            ->andWhere(['status' => SaleRecord::STATUS_SUCCESS])
            ->andWhere(['between', 'updated_at' , $date, $date + 86399])
            ->all();

        foreach ($records as $record)
        {
            $total += $record->sell_price;

            $item = Item::find()->where([
                'id' => $record->item_id
            ])->one();

            $product = Product ::find()->where([
                'id' => $item->product_id
            ])->one();

            $cost_price += $product->cost;
        }

        $quantity_of_order = count($records);
        $total_earn        = $total;
        $net_profit        = $total_earn - $cost_price;

        if (!empty($store->user_id))
        {
            $manager = User::find()->where([
                'id' => $store->user_id]
            )->one()->username;

            return [
                'store_name'        => $store->name,
                'store_manager'     => $manager,
                'quantity_of_order' => $quantity_of_order,
                'total_earn'        => $total_earn,
                'net_profit'        => $net_profit
            ];
        }
        return [
            'store_name'        => $store->name,
            'store_manager'     => NULL,
            'quantity_of_order' => $quantity_of_order,
            'total_earn'        => $total_earn,
            'net_profit'        => $net_profit
        ];
    }

    public static function find_store_all_finance_oneday($date)
    {
        $total      =  Store::STATUS_INITIAL;
        $cost_price =  Store::STATUS_INITIAL;

        $records = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS])
            ->andWhere(['between','updated_at' , $date, $date + 86399])
            ->all();

        foreach ($records as $record)
        {
            $total += $record->sell_price;

            $item = Item::find()->where([
                'id' => $record->item_id
            ])->one();

            $product = Product ::find()->where([
                'id' => $item->product_id
            ])->one();

            $cost_price += $product->cost;
        }

        $quantity_of_order = count($records);
        $total_earn        = $total;
        $net_profit        = $total_earn - $cost_price;

        return array(
            'quantity_of_order' => $quantity_of_order,
            'total_earn'        => $total_earn,
            'gross_profit'      => $total_earn,
            'net_profit'        => $net_profit
        );
    }

    public static function find_store_salcerecord($array)//寻找订单
    {
        $date       = ArrayHelper::getValue($array, 'date', Null);
        $store_id   = ArrayHelper::getValue($array, 'store_id', Null);

        $time         = $date;
        $store_order[]  = '';

        if (!empty($store_id))
        {
            $records = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
                ->andWhere(['between', 'created_at' , $time, $time+86399])
                ->andWhere(['store_id' => $store_id])
                ->all();

            if ($records)
            {
                foreach ($records as $record)
                {
                    $store_order[] = [
                        'date'          => $date,
                        'order_number'  => $record->order_number,
                        'box_code'      => $record->box_code,
                        'store_name'    => $record->store->name,
                        'item_name'     => $record->item->name,
                        'sell_price'    => $record->sell_price,
                        'cost'          => product::find()->where(['id' => $record->item->product_id])->one()->cost,
                        'creation_time' => date('d-m-Y H:i:s', $record->created_at),
                        'end_time'      => date('d-m-Y H:i:s', $record->updated_at),
                    ];
                }
            }
        }

        if (empty($store_id))
        {
            $records = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
                ->andWhere(['between', 'created_at'  , $time, $time + 86399])
                //->andWhere(['store_id'=>$store_id])
                ->all();
            if ($records)
            {
                foreach ($records as $record)
                {
                    $store_order[] = [
                        'date'          => $date,
                        'order_number'  => $record->order_number,
                        'box_code'      => $record->box_code,
                        'store_name'    => $record->store->name,
                        'item_name'     => $record->item->name,
                        'sell_price'    => $record->sell_price,
                        'cost'          => product::find()->where(['id' => $record->item->product_id])->one()->cost,
                        'creation_time' => date('d-m-Y H:i:s', $record->created_at),
                        'end_time'      => date('d-m-Y H:i:s', $record->updated_at),
                    ];
                }
            }
        }

        return $store_order;
    }

    public static function get_store_salerecord($array) //导出roder
    {
        $date1    = ArrayHelper::getValue($array, 'date1', Null);
        $date2    = ArrayHelper::getValue($array, 'date2', Null);
        $store_id = ArrayHelper::getValue($array, 'store_id', Null);

        $catime1 = strtotime($date1);
        $catime2 = strtotime($date2);

        if (!empty($store_id))
        {
            for ($i = 1; $i <= (strtotime($date2) - strtotime($date1) + 86400) / 86400 ; $i++)
            {
                $date   = $catime1+86400*($i)-86400;
                $records = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
                    ->andWhere(['between', 'created_at' , $date, $date+86399])
                    ->andWhere(['store_id' => $store_id])
                    ->all();

                if ($records)
                {
                    foreach ($records as $record)
                    {
                        $all_order[] = [
                            'date'          => date('d-m-Y', $date),
                            'order_number'  => $record->order_number,
                            'box_code'      => $record->box_code,
                            'store_name'    => $record->store->name,
                            'item_name'     => $record->item->name,
                            'sell_price'    => $record->sell_price,
                            'cost'          => product::find()->where(['id' => $record->item->product_id])->one()->cost,
                            'creation_time' => date('d-m-Y H:i:s', $record->created_at),
                            'end_time'      => date('d-m-Y H:i:s', $record->updated_at),
                        ];
                    }
                }
            }

        }

        if (empty($store_id))
        {
            for ($i = 1; $i <= (strtotime($date2) - strtotime($date1) + 86400) / 86400 ; $i++)
            {
                $date   = $catime1 + 86400 * ($i) - 86400;
                $records = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
                    ->andWhere(['between', 'created_at' , $date, $date+86399])
                    //->andWhere(['store_id'=>$store_id])
                    ->all();

                if ($records)
                {
                    foreach ($records as $record)
                    {
                        $all_order[] = [
                            'date'          => date('d-m-Y', $date),
                            'order_number'  => $record->order_number,
                            'box_code'      => $record->box_code,
                            'store_name'    => $record->store->name,
                            'item_name'     => $record->item->name,
                            'sell_price'    => $record->sell_price,
                            'cost'          => product::find()->where(['id' => $record->item->product_id])->one()->cost,
                            'creation_time' => date('d-m-Y H:i:s', $record->created_at),
                            'end_time'      => date('d-m-Y H:i:s', $record->updated_at),
                        ];
                    }
                }
            }
        }

        return $all_order;
    }

    public function store_all_finance($date1, $date2)//date
    {
        $catime1 = strtotime($date1);
        $catime2 = strtotime($date2);

        $total_earn = 0;
        $net_profit = 0;

        $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
        ->andWhere(['between','created_at' ,$catime1,$catime2+86399])
        ->all();

        if ($models)
        {
            foreach ($models as $salerecord_model)
            {
                $total_earn += $salerecord_model->sell_price;
                $net_profit += $salerecord_model->sell_price - product::find()->where([
                    'id' => $salerecord_model->item->product_id
                ])->one()->cost;
            }

            $store_all_data[] =  array(
                'date'              => $date1 . "/" . $date2,
                'quantity_of_order' => count($models),
                'total_earn'        => $total_earn ,
                'gross_profit'      => $total_earn,
                'net_profit'        => $net_profit
            );
        }

        for ($i = 1; $i <= (strtotime($date2) - strtotime($date1) + 86400) / 86400; $i++)
        {
            $date = $catime1 + 86400 * ($i) - 86400;

            $all_date[] = array(
                'date'              => $date,
                'quantity_of_order' => Finance::total_financial_inquiry($date)['quantity_of_order'],
                'total_earn'        => Finance::total_financial_inquiry($date)['total_earn'],
                'gross_profit'      => Finance::total_financial_inquiry($date)['gross_profit'],
                'net_profit'        => Finance::total_financial_inquiry($date)['net_profit'],
            );
        }

        if (!empty($store_all_data))
        {
            return array($store_all_data,$all_date);
        }


        return array(array(),$all_date);

    }

    public function store_finances($array)//date
    {
        $date1    = ArrayHelper::getValue($array,'date1',Null);
        $date2    = ArrayHelper::getValue($array,'date2',Null);
        $store_id = ArrayHelper::getValue($array,'store_id',Null);

        $catime1 = strtotime($date1);
        $catime2 = strtotime($date2);

        $total_earn = 0;
        $net_profit = 0;

        if (!empty($store_id))
        {
            $models = SaleRecord::find()
            ->where(['status' => SaleRecord::STATUS_SUCCESS,])
            ->andWhere(['between','created_at' , $catime1, $catime2+86399])
            ->andWhere(['store_id' => $store_id])
            ->all();

            if ($models)
            {
                foreach ($models as $salerecord_model)
                {
                    $total_earn += $salerecord_model->sell_price;
                    $net_profit += $salerecord_model->sell_price - product::find()->where([
                        'id' => $salerecord_model->item->product_id
                    ])->one()->cost;
                }

                $store_all_data[] = array(
                    'date'              => $date1 . "/" . $date2,
                    'quantity_of_order' => count($models),
                    'total_earn'        => $total_earn ,
                    'gross_profit'      => $total_earn,
                    'net_profit'        => $net_profit,
                    'store_id'          => $store_id,
                );
            }

            for ($i = 1; $i <= (strtotime($date2) - strtotime($date1) + 86400) / 86400; $i++)
            {
                $date = $catime1 + 86400 * ($i) - 86400;
                $all_date[] = array(
                    'date'              => $date,
                    'store_id'          => $store_id,
                    'store_name'        => Finance::financial_detail_inquiry($store_id,$date)['store_name'],
                    'quantity_of_order' => Finance::financial_detail_inquiry($store_id,$date)['quantity_of_order'],
                    'total_earn'        => Finance::financial_detail_inquiry($store_id,$date)['total_earn'],
                    'gross_profit'      => Finance::financial_detail_inquiry($store_id,$date)['total_earn'],
                    'net_profit'        => Finance::financial_detail_inquiry($store_id,$date)['net_profit'],
                );
            }

        }

        if (empty($store_id))
        {
            $models = SaleRecord::find()->where(['status' => SaleRecord::STATUS_SUCCESS,])
            ->andWhere(['between','created_at' ,$catime1,$catime2+86399])
            ->all();

            if ($models)
            {
                foreach ($models as $salerecord_model)
                {
                    $total_earn += $salerecord_model->sell_price;
                    $net_profit += $salerecord_model->sell_price - Product::find()->where([
                        'id' =>$salerecord_model->item->product_id
                    ])->one()->cost;
                }

                $store_all_data[] =  array(
                    'date'              => $date1 . "/" . $date2,
                    'quantity_of_order' => count($models),
                    'total_earn'        => $total_earn ,
                    'gross_profit'      => $total_earn,
                    'net_profit'        => $net_profit
                );
            }

            for ($i = 1; $i <= (strtotime($date2)-strtotime($date1)+86400)/86400 ; $i++)
            {
                $date = $catime1+86400*($i)-86400;
                $all_date[] = array(
                    'date'              => $date,
                    'quantity_of_order' => Finance::total_financial_inquiry($date)['quantity_of_order'],
                    'total_earn'        => Finance::total_financial_inquiry($date)['total_earn'],
                    'gross_profit'      => Finance::total_financial_inquiry($date)['gross_profit'],
                    'net_profit'        => Finance::total_financial_inquiry($date)['net_profit'],
                );
            }

        }

        if (!empty($store_all_data))
        {
            return array($store_all_data,$all_date);
        }

        return array(array(),$all_date);


    }


}
