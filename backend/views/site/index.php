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


<script src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
<script type="text/javascript">

      var model;
        $.ajax({
            type: 'get',
            url: 'http://localhost/vending-machine/backend/web/site/sales',
            success: function (json) {
                //$("#contentDiv").html("");
                setTimeout(() => {
                    model = json.a
                },0);

                //alert(model);
            }

        });

        // setTimeout(() => {
        //     alert(model)
        // },300);
        console.log('1');

        setTimeout(function() {
        console.log('2');
         });
    //    Process.nextTick(() => console.log(3));

        Process.on('exit', function() {
    // 设置一个延迟执行
            setTimeout(function() {
                console.log('主事件循环已停止，所以不会执行');
            }, 0);
            console.log('退出前执行');
        });
        setTimeout(function() {
            console.log('1');
        }, 500);

        //代码1
        // console.log('先执行这里5');
        // setTimeout(() => {
        //     console.log('执行啦')
        // },0);
        // //代码2
        // console.log('先执行这里');
        // setTimeout(() => {
        //     console.log('执行啦')
        // },3000);

        // function test(){
        //      var aa = "test";
        //      aa +="只声明，但不调用该函数时，该函数会不会执行？"; //添加内容
        //      alert(aa);
        //      aa = "该函数的变量不会执行！";
        //      alert(aa);
        //    }
        //  test();

</script>











<h1 class="text-center">Data Analysis Graph</h1>

<div class="row">
    <div class="chart-container col-lg-12">


        <div class="col-lg-6">
            <h4>Sale Chart</h4>
            <canvas id="myChart1" width="50" height="30"></canvas>
        </div>
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






        <div class="row">
            <div class="col-lg-4">
<script>
      var ctx = document.getElementById('myChart').getContext('2d');
      var chart = new Chart(ctx, {
        type: 'line',
        data: {
        labels:[correctUsage] ,
        <?= die();?>
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
  },
  {
      label: 'Total Amount (RM)',
      backgroundColor: 'transparent',
      borderColor: 'rgb(100, 99, 132)',
      data: [<?= implode($data, ',') ?> ]
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
var ctx = document.getElementById('myChart2').getContext('2d');
var chart = new Chart(ctx, {
type: 'bar',

data: {

labels: [<?= implode(array_column($b,'0'),',')?>],
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
    data: [<?=implode(array_column($b,'1'),',')?>,'0']
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

    labels: [
        //<
        //?=implode(array_column($a,'0'),',')?> ],
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
        data: [
            //<
            //?=implode(array_column($a,'1'),',')?> ]
    }]
    },

    options: {},
    });
    </script>
    </div>
    </div>



  </div>
</div>
