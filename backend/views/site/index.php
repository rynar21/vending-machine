<?php
use common\models\SaleRecord;

/* @var $this yii\web\View */

$this->title = 'chart';

$labels = [];
$data = [];


$model_time = SaleRecord::find()->where(['status' => 10])->all();


for ($i=0; $i < 7 ; $i++) {
  $labels[] = date('"Y-m-d "', strtotime(-(24*60*60*$i-$i) .'seconds'));
  sort($labels);
}

for ($i=count($labels); $i >=1; $i--) {
  $model_count = SaleRecord::find()
  ->where(['between', 'updated_at', strtotime(-(24*60*60*$i-$i) .'seconds'),strtotime(-(24*60*60*($i-1)-($i-1)) .'seconds')   ])
  ->andWhere(['status'=> 10])
  ->count();
$data[]=$model_count;
}
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
        datasets: [{
            label: 'No. of success transaction',
            // backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= implode($data, ',') ?> ]
        }]
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
