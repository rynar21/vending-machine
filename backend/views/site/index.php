<?php

/* @var $this yii\web\View */

//$this->title = 'Data Analysis Graph';
?>
<!-- <div class="site-index">
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
</div> -->

<!-- <form id= "" action= "https://hooks.slack.com/services/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" method= "post" >
 <h1 >测试通过Rest接口上传文件 </h1>

 <p >关键字1： <input type ="text" name="text" /></p>
 <input type ="submit" value="上传"/>
</form> -->

<script type="text/javascript">
            $.ajax({
            url:" https://hooks.slack.com/services/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",
            type:'post',
            data:JSON.stringify({'text:"Hello, World!"}')
            // dataType:'json',
            // data:{text:"Hello, World!"}
        });


        // $.ajax({
        //     url: '<?php //echo Yii::$app->request->baseUrl. '/site/data' ?>',
        //     type: 'get',
        //     // data: {labels:$("#labels").val() ,data:$("#data").val() ,data_amount:$("#data_amount").val() ,count:$("#count").val() },
        //     success: function (data) {
        //         data=[data.labels,data.data,data.data_amount,data.data_keys,data.data_values,'']
        //         id=['salesChart','bestSellChart']
        //         renderChart(data);
        //     }
        // });
        //
        // function renderChart(data) {
        //         for (var i = 0; i < id.length; i++) {
        //             var ctx = document.getElementById(id[i]).getContext('2d');
        //                        var chart = new Chart(ctx, {
        //                          type: 'line',
        //                          data: {
        //                          labels:data[i*3],
        //                          datasets: [{
        //                              label: 'No. of success transaction',
        //                              backgroundColor:'transparent',
        //                              borderColor:'rgba(54, 162, 235, 1)',
        //                              data:data[i*3+1],
        //                          },
        //                          {
        //                              label: 'Total Amount (RM)',
        //                              backgroundColor: 'transparent',
        //                              borderColor: 'rgb(255, 99, 132)',
        //                              data:data[i*3+2],
        //                          }
        //                      ]
        //                      },
        //
        //                  options: {
        //                      scales: {
        //                          yAxes: [{
        //                              ticks: {
        //                                  beginAtZero:true
        //                              }
        //                          }]
        //                      }
        //                  },
        //              });
        //          }
        //      }
</script>
