<?php

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
                    <canvas id="salesChart"  width="50" height="30"></canvas>
                </div>

                <div class="col-lg-6">
                    <h4>Best Selling Type Chart</h4>
                    <canvas id="bestSellChart"  width="50" height="30"></canvas>
                </div>
            </div>
        </div>
</div>

<script type="text/javascript">

// var isLoaded = false;
// function reqs(opts) {
//     $.ajax({
//         type: 'get',
//         url: '<?php //echo Yii::$app->request->baseUrl. '/site/data' ?>',
//         dataType: 'json',
//         beforeSend: function() {
//             if(opts.init === 1) {
//                 $('.salesChart').show();
//             }
//             isLoaded = false;
//         },
//         success: function(data) {
//             data=[data.labels,data.data,data.data_amount,data.data_keys,data.data_values,'']
//             id=['salesChart','bestSellChart']
//             console.log(data);
//             renderChart(data);
//         },
//         complete: function() {
//             if(opts.init === 1) {
//                 $('.salesChart').hide();
//             }
//             isLoaded = true;
//         },
//         error: function() {
//             console.log('请求失败~');
//         }
//     });
// }
//         reqs({"init": 1});
//         setInterval(function() {
//             isLoaded && reqs({"init": 0});
//         }, 3000);

        $.ajax({
            url: '<?php echo Yii::$app->request->baseUrl. '/site/data' ?>',
            type: 'get',
            // data: {labels:$("#labels").val() ,data:$("#data").val() ,data_amount:$("#data_amount").val() ,count:$("#count").val() },
            success: function (data) {
                data=[data.labels,data.data,data.data_amount,data.data_keys,data.data_values,'']
                id=['salesChart','bestSellChart']
                renderChart(data);
            }
        });

        function renderChart(data) {
                for (var i = 0; i < id.length; i++) {
                    var ctx = document.getElementById(id[i]).getContext('2d');
                               var chart = new Chart(ctx, {
                                 type: 'line',
                                 data: {
                                 labels:data[i*3],
                                 datasets: [{
                                     label: 'No. of success transaction',
                                     backgroundColor:'transparent',
                                     borderColor:'rgba(54, 162, 235, 1)',
                                     data:data[i*3+1],
                                 },
                                 {
                                     label: 'Total Amount (RM)',
                                     backgroundColor: 'transparent',
                                     borderColor: 'rgb(255, 99, 132)',
                                     data:data[i*3+2],
                                 }
                             ]
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
             }
</script>
