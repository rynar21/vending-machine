<?php
use common\models\SaleRecord;
use common\models\Item;
use common\models\Product;
use backend\models\ProductSearch;
use yii\helpers\Json;
use yii\helpers\BaseJson;

/* @var $this yii\web\View */
$this->title = 'Data Analysis Graph';
?>

<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>

<h1 class="text-center">Data Analysis Graph</h1>
<div class="row">
     <div class="chart-container col-lg-12" >
        <div class="col-lg-6" id="myDiv">
            <h4>Sale Chart</h4>
            <canvas id="myChart1" width="50" height="30"></canvas>
        </div>

        <div class="col-lg-6">
            <h4>Sale Chart</h4>
            <canvas id="myChart2" width="50" height="30"></canvas>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-4">
 <script type="text/javascript">

        
        $.ajax({
            type: 'get',
            url: 'http://localhost/vending-machine/backend/web/site/sales',
            success: function (json) {
                    model_labels = json.labels
                    model_pricesum =json.pricesum
                    model_data=json.data
                    model_type=json.type
                    model_number=json.number
                    console.log(json);
                    Suju();
                    Suji();
            }

        });

        function Suju(){
            var ctx = document.getElementById("myChart1").getContext('2d');
            var chart = new Chart(ctx, {
              type: 'line',

              data: {

              labels: model_labels,
              datasets: [{
                  label: 'No. of success transaction',
                  backgroundColor: 'transparent',
                  borderColor: 'rgb(255, 99, 132)',
                  data: model_data,
              },
              {
                  label: 'Total Amount (RM)',
                  backgroundColor: 'transparent',
                  borderColor: 'rgb(100, 99, 132)',
                  data: model_pricesum
              }]
            },
            options: {},
            });
        }

        function Suji(){

            var ctx = document.getElementById("myChart2").getContext('2d');
            var chart = new Chart(ctx, {
            type: 'bar',

            data: {
            labels: model_number ,
            datasets: [{
                label: 'No. of success transaction',
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)',
                ],
                borderColor: [
                   'rgba(255, 99, 132, 1)',
                   'rgba(54, 162, 235, 1)',
                   'rgba(255, 206, 86, 1)',
                   'rgba(75, 192, 192, 1)',
                   'rgba(153, 102, 255, 1)',
                ],
                data:model_type,
            }]
            },
            options: {
                scales: {
                       yAxes: [{
                           ticks: {
                               beginAtZero:true
                           }
                       }]
                   }
            },
            });
        }
</script>
  </div>
</div>

  </div>
</div>
