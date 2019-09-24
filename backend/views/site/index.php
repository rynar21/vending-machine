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
<!-- <form action="https://ry92.requestcatcher.com" method="post">
Name: <input type="text" name="name"><br>
<input type="submit">
</form> -->

<script>
var formData = JSON.stringify($("#myForm").serializeArray());

$.ajax({
    type: "GET",
    url: 'http://localhost/vending-machine/backend/web/site/ajax',
        success: function (data) {
            renderChart(data.labels , data.data , data.data_amount);
        }

});

$.ajax({
    type: "POST",
    // cache: false,
    url: "https://ry92.requestcatcher.com/",
    data:  {"text":"Hello, World!"},
    // crossDomain: true,
    contentType: "application/json",
    // contentType: "application/json; charset=utf-8",
    dataType: "json",
});

    function renderChart(label, data, amount)
    {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var chart = new Chart(ctx, {
          type: 'line',
          data: {
          labels: label,
          datasets: [{
              label: 'No. of success transaction',
              backgroundColor:'transparent',
              borderColor:'rgba(54, 162, 235, 1)',
              data: data,
          },
          {
              label: 'Total Amount (RM)',
              backgroundColor: 'transparent',
              borderColor: 'rgb(255, 99, 132)',
              data: amount
          }
      ]
      },

      options: {},
        });
    }


        var ctx = document.getElementById('bestSellChart').getContext('2d');
        var chart = new Chart(ctx, {
        type: 'bar',

        data: {

        labels: [],
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
            data: []
        }]
    },

    options: {},
});

</script>
