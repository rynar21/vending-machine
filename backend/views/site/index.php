

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
            data: [<?= implode($data_amount, ',') ?> ]
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
      data: [<?= implode($data_amount, ',') ?> ]
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

labels: [<?= implode(array_column($count,'1'),',')?>],
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
    data: [<?= implode(array_column($count,'0'),',')?>,'0']
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

labels: [<?= implode(array_column($count,'1'),',')?>],
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
    data: [<?= implode(array_column($count,'0'),',')?>,'0']
}]
},

options: {},
});
</script>
</div>
</div>

  </div>
</div>
