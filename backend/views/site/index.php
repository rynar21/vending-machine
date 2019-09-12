<?php
/* @var $this yii\web\View */

$this->title = 'chart';
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
