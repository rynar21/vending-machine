<?php
/* @var $this yii\web\View */
use common\models\SaleRecord;
use common\models\Item;
use common\models\Product;
$this->title = 'chart';
$product=[];
$data_type=[];
$array = [];

            // $array=['a'=>1,'b'=>2];
            // $array['a']=2;

            // print_r($array);
            // die();
            $data_item = Item::find()
            ->Where([
                'between',
                'updated_at',
                strtotime(date('Y-m-d',strtotime(-29 .' day'))),
                strtotime(date('Y-m-d',strtotime(0 .' day')))
            ])
            ->where(['status'=>10])
            ->all();
            foreach ($data_item as $item)
            {
                $data_type[]=$item->product->id;
                if (!array_key_exists($item->product->id,$data_type)) {
                    $data_type[$item->product->category]=1;
                }
                $data_type[$item->product->category]+=1;
            }
            print("<pre>");
            // print_r(count($product));
            // print_r($data_product);
            print_r($data_type);
            // print_r($array);
            print("</pre>");
            die();
            // foreach ($data_item as$item)
            // {
            //     if (array_key_exists($item[$data_product->sku], $count_item)) {
            //         $count_item[$item[$data_product->sku]]['fund'] += $v['fund'];
            //     } else {
            //         $newArr[$v['id']] = $v;
            //     }
            // }
            // $data_type[] = "'".$data_product->sku."'";
            $count_data[] = count($data_item);
        // $count_data[] = count($data_type);
        for ($z=0; $z <=count($count_data)-1; $z++)
        {
            // if (!empty($count_data[$z]&&$data_type[$z]))
            // {
                $array[]=array($count_data[$z],$data_type[$z]);
            // }
        }
        for ($y=0; $y <count($count_data)-1 ; $y++) {
            array_multisort(array_column($array,'0'),SORT_DESC,$array);
        }
        $count=array_slice($array,0,5);
?>

<canvas id="myChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<div class="site-index">
    <div class="body-content">
        <div class="row">
                <?php
                    print("<pre>");
                    // print_r(count($product));
                    // print_r($data_product);
                    print_r($data_type);
                    // print_r($array);
                    print("</pre>");
                ?>
        </div>
    </div>
</div>
<script>
  var ctx = document.getElementById('myChart').getContext('2d');
  var chart = new Chart(ctx, {
    type: 'line',
    data: {
            labels: [<?= implode($labels, ',') ?>],
            datasets: [
                            {
                                label: 'No. of success transaction',
                                backgroundColor: 'transparent',
                                borderColor: 'rgb(100, 50, 150)',
                                data: [<?= implode($data, ',') ?> ]
                            },
                            {
                                label: 'Total Amount (RM)',
                                backgroundColor: 'transparent',
                                borderColor: 'rgb(0, 0,0 )',
                                data: [<?= implode($data_amount, ',') ?> ]
                            }
                        ]
        },
            options: {
            }
        });
</script>
