<?php
use yii\helpers\Html;
use yii\helpers\Url;
use common\models\Item;
use yii\helpers\ArrayHelper;
use yii\bootstrap\ActiveForm;
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>

<?php if($item):
     ?>
        <div class="col-sm-3 col-xs-6 box_row " >
             <!-- 产品 显示框 -->
            <div class="box_item thumbnail  "style="width:100%; margin-bottom: -12px;">
                <a href="<?= Url::base()?>/item/view?id=<?= $item->id ?>">
                    <!-- 产品：图片 显示框 -->
                    <div class="row item_image">
                        <img src="<?=  $item->imageUrl ?>" class="img-responsive center-block"/>
                    </div>

                    <!-- 产品：名字 显示框 -->
                    <div class="row item_name">
                        <?= $item->name ?>
                    </div>

                    <!-- 产品：购买的按钮 -->
                    <div class="row item_buy">
                        <span class="item_price">
                            <?= $item->pricing ?>
                        </span>
                    </div>

                    <!-- FOR CART Features -->
                    <!-- <div id="app">
                        <label for="aaa">
                            <input type="checkbox" v-model="selected" value="<php?= $item->id?>" id="aaa"> aaa
                        </label>
                        <pre>{{ selected | json }}</pre>
                    </div> -->

                <!-- <script type="text/javascript">
                $(".section1 input[type=checkbox][name=hobby]").change(function(){
                         var obj = document.getElementsByName("hobby");
                 var check_val = [];
                 for(k in obj){
                    if(obj[k].checked){
                        check_val.push(obj[k].value);
                    }
                 }
                 $(".section1 .res").text(check_val);
                    });
                    </script> -->
                </a>
            </div>
        </div>
<?php endif;?>
<script type="text/javascript">
new Vue({
    el:'#app',
    data:{
        selected:[],

    }
})
</script>
