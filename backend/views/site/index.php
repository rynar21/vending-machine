<?php
use common\models\SaleRecord;
use common\models\Item;
/* @var $this yii\web\View */

$this->title = 'chart';

$labels = [];
$data = [];
$data_amount=[];
$total=0;

// $model_time = SaleRecord::find()->where(['status' => 10])->all();
    for ($i=0; $i < 7 ; $i++)
     {
      $labels[] = date('"Y-m-d "', strtotime(-(24*60*60*$i-$i) .'seconds'));
      sort($labels);
    }

// for ($j=1; $j < count($labels)+1; $j++) {
//   $model_count = SaleRecord::find()
//   ->where(['between', 'updated_at', strtotime(-(24*60*60*$j-$j) .'seconds'),strtotime(-(24*60*60*($j-1)-($j-1)) .'seconds')])
//   ->andWhere(['status'=> 10])
//   ->count();
// $data[]=$model_count;
// }
    for ($j=count($labels); $j>=1 ; $j--)
     {
      $model_count = SaleRecord::find()
      ->where(['between', 'updated_at', strtotime(-(24*60*60*$j-$j) .'seconds'),strtotime(-(24*60*60*($j-1)-($j-1)) .'seconds')])
      ->andWhere(['status'=> 10])
      ->count();
      $data[]=$model_count;
    }
    for ($j=count($labels); $j >=1 ; $j--)
     {
        $sale_record = SaleRecord::find()->where(['status' => 10])
        ->andWhere(['between', 'created_at' , strtotime(-(24*60*60*$j-$j) .'seconds'),strtotime(-(24*60*60*($j-1)-($j-1)) .'seconds')])
        ->all();
        foreach ($sale_record as $model)
        {
            $item=Item::find()->where(['id'=>$model->item_id])->all();
            foreach ($item as $price )
             {
                $total+=$price->price ;
                // $total+=$total ;
            }
          }
          $data_amount[]=$total;
      }
  // print_r($labels);
  //
  // print_r($data)
?>

<canvas id="myChart"></canvas>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
    <script>
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
        // The type of chart we want to create
        type: 'line',

    // The data for our dataset
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

    // Configuration options go here
    options: {
    }
});
</script>
            </div>
        </div>

    </div>
</div>
