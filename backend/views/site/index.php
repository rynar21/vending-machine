

<?php
use common\models\SaleRecord;
use common\models\Item;
use common\models\Product;
use backend\models\ProductSearch;


/* @var $this yii\web\View */

$this->title = 'Data Analysis Graph';
?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<h1 class="text-center">Data Analysis Graph</h1>
<div class="chart-container col-lg-12">
    <div class="col-lg-6">
        <h4>Overall Chart</h4>
        <canvas id="myChart" width="50" height="30"></canvas>
    </div>

    <div class="col-lg-6">
        <h4>Sale Chart</h4>
        <canvas id="myChart1" width="50" height="30"></canvas>
    </div>


</div>
<div class="row">
    <div class="chart-container col-lg-12">
<div class="col-lg-6">
    <h4>Sale Chart</h4>
    <canvas id="myChart2" width="50" height="30"></canvas>
</div>

<div class="col-lg-6">
    <h4>Sale Chart</h4>
    <canvas id="myChart3" width="50" height="30"></canvas>
</div>
</div>
</div>

<?php


?>


</script>
<?php
    $labels = [];
    $data = [];
    $pricesum=[];
    $sk=[];
    $kunum=[];




        $model_product = Product::find()->all();
            for ($i = 1; $i <= count($model_product); $i++) {
                $s = Item::find()->where(['product_id'=>$i,'status'=>10])->all();
                if ($s) {
                    foreach ($s as $sok) {
                        $modelsk=Product::find()->where(['id'=>$sok->product_id])->one();
                    }
                    $sk[]="'".$modelsk->sku."'";
                    //asort($sk);
                }
                $kunum[]=count($s);
            //    bubble_sort($kunum);
            }




         print_r($kunum)."\n";
         echo "<br />";
          print_r($sk)."\n";




        for ($i=0; $i < 7 ; $i++) {
          $labels[] = date('"Y-m-d "', strtotime(-$i.'days'));
          sort($labels);
        }

        for ($i=count($labels); $i >=1 ; $i--)
        {
          $model_count = SaleRecord::find()
          ->where([
              'between',
              'updated_at',
              strtotime(date('Y-m-d',strtotime(1-$i.' day'))),
              strtotime(date('Y-m-d',strtotime(2-$i.' day')))
           ])
          ->andWhere(['status'=> 10])
          ->count();
          $data[]=$model_count;
        }

        for ($j=count($labels); $j >=1 ; $j--) {
            $total = 0;
            $models = SaleRecord::find()
            ->where(['status' => 10])
            ->andWhere([
                'between',
                'created_at' ,
                strtotime(date('Y-m-d',strtotime(1-$j.' day'))),
                strtotime(date('Y-m-d',strtotime(2-$j.' day')))
            ])
            ->all();

            foreach ($models as $model)
             {
                $model1=Item::find()->where(['id'=>$model->item_id])->all();
                    foreach ($model1 as $itemmodel )
                     {
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
  type: 'radar',

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

<div class="row">
    <div class="col-lg-4">
<script>
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
type: 'bar',

data: {

labels: [<?= implode($sk,',')?>],
datasets: [{
    label: 'No. of success transaction',
    backgroundColor: [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        // 'rgba(255, 159, 64, 0.8)'
    ],
    borderColor: [
       'rgba(255, 99, 132, 1)',
       'rgba(54, 162, 235, 1)',
       'rgba(255, 206, 86, 1)',
       'rgba(75, 192, 192, 1)',
       'rgba(153, 102, 255, 1)',
       // 'rgba(255, 159, 64, 1)'
    ],
    data: [<?= implode($kunum,',')?>,'0']
}]
},

options: {},
});
</script>
</div>
</div>


<div class="row">
    <div class="col-lg-4">
<script>
var ctx = document.getElementById('myChart3').getContext('2d');
var chart = new Chart(ctx, {
type: 'pie',

data: {

labels: [<?= implode($sk,',')?>],
datasets: [{
    label: 'No. of success transaction',
    backgroundColor: [
        'rgba(255, 99, 132, 0.8)',
        'rgba(54, 162, 235, 0.8)',
        'rgba(255, 206, 86, 0.8)',
        'rgba(75, 192, 192, 0.8)',
        'rgba(153, 102, 255, 0.8)',
        'rgba(255, 159, 64, 0.8)'
    ],
    borderColor: [
       'rgba(255, 99, 132, 1)',
       'rgba(54, 162, 235, 1)',
       'rgba(255, 206, 86, 1)',
       'rgba(75, 192, 192, 1)',
       'rgba(153, 102, 255, 1)',
       'rgba(255, 159, 64, 1)'
    ],
    data: [<?= implode($kunum,',')?> ]
}]
},

options: {},
});
</script>
</div>
</div>

  </div>
</div>
