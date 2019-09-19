<?php
use common\models\SaleRecord;
use common\models\Item;
use common\models\Product;
use backend\models\ProductSearch;


/* @var $this yii\web\View */

$this->title = 'Data Analysis Graph';
?>
<div class="site-index">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
        <div class="body-content">
            <h1 class="text-center">Data Analysis Graph</h1>
            <div class="chart-container col-lg-12">
                <div class="col-lg-6">
                    <h4>Sales Chart</h4>
                    <canvas id="salesChart" width="50" height="30"></canvas>
                </div>

                <div class="col-lg-6">
                    <h4>Best Selling Type Chart</h4>
                    <canvas id="bestSellChart" width="50" height="30"></canvas>
                </div>
            </div>
        </div>
</div>

<script>
      var ctx = document.getElementById('salesChart').getContext('2d');
      var chart = new Chart(ctx, {
        type: 'line',
        data: {
        labels: [<?= implode($labels, ',') ?>],
        datasets: [{
            label: 'No. of success transaction',
            backgroundColor:'transparent',
            borderColor:'rgba(54, 162, 235, 1)',
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

        var ctx = document.getElementById('bestSellChart').getContext('2d');
        var chart = new Chart(ctx, {
        type: 'bar',

        data: {

        labels: [<?= implode(array_column($count,'1'),',')?>],
        datasets: [{
            label: 'No. of sold item',
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
