

<?php
use common\models\SaleRecord;
use common\models\Item;
use frontend\controllers\SaleRecordController;

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>



<canvas id="myChart" width="100" height="50"></canvas>
<?php


?>


</script>
<?php
$labels = [];
$data = [];
$pricesum=[];

$model_time = SaleRecord::find()->where(['status' => 10])->all();


for ($i=0; $i < 7 ; $i++) {
  $labels[] = date('"Y-m-d "', strtotime(-$i.'day'));
  sort($labels);
}

for ($i=count($labels); $i >=1 ; $i--) {
  $model_count = SaleRecord::find()
  ->where(['between', 'updated_at', strtotime(-$i .'days'),strtotime(1-$i .'days')   ])
  ->andWhere(['status'=> 10])
  ->count();
 $data[]=$model_count;
}
for ($j=count($labels); $j >=1 ; $j--) {

    $total = 0;
    $models = SaleRecord::find()->where(['status' => 10])
    ->andWhere(['between', 'created_at' , strtotime(-$j. 'days')  ,strtotime(1-$j .'days') ])
    ->all();
     foreach ($models as $model) {
        $model1=Item::find()->where(['id'=>$model->item_id])->all();
            foreach ($model1 as $itemmodel ) {
            $arr= $itemmodel->price ;
            $total += $arr;
    }
  }
     $pricesum[]=$total;
}

// print_r($labels);
//
// print_r($data);

?>
<canvas id="myChart1"></canvas>

<canvas id="myChart"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<div class="site-index">

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
<script>
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
        type: 'line',

        data: {

        labels: [<?= implode($labels, ',') ?>],
        datasets: [{
            label: 'No. of success transaction',
            backgroundColor:'transparent',
            borderColor: 'rgb(0, 0, 0)',
            data: [<?= implode($data, ',') ?> ],

        },
        {
            label: 'Total Amount (RM)',
             backgroundColor: 'transparent',
            borderColor: 'rgb(255, 99, 132)',
            data: [<?= implode($pricesum, ',') ?> ]
        }
    ]
    },

    options: {},
});
</script>
   </div>
  </div>

  <div class="row">
      <div class="col-lg-4">
<script>
var ctx = document.getElementById('myChart1').getContext('2d');
var chart = new Chart(ctx, {
  type: 'line',

  data: {

  labels: [<?= implode($labels, ',') ?>],
  datasets: [{
      label: 'No. of success transaction',
       backgroundColor: 'transparent',
      borderColor: 'rgb(255, 99, 132)',
      data: [<?= implode($pricesum, ',') ?> ]
  }]
},

options: {},
});
</script>
</div>
</div>
  </div>
</div>
