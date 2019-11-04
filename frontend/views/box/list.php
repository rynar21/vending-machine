<?php
use common\models\Store;
use common\models\Box;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\widgets\LinkPager;


// @models $item_dataProvider = ItemSearch() model
/*
    1. Views > store > view.php
    2. Views > box > _list.php
    3. Views > box > _view.php
*/
?>
<script src="https://cdn.bootcss.com/vue/2.2.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue/2.2.2/vue.min.js"></script>
<script src="https://cdn.staticfile.org/vue-resource/1.5.1/vue-resource.min.js"></script>
<script type="text/javascript">
    window.onload = function(){
        var app = new Vue({
          el: '#app',
          data:{
             selected:[],
          },
      })
    }
    //$("#pro").hide();
</script>
<?php $form = ActiveForm::begin(['action' => ['box/list'],'method'=>'post',]); ?>
<div id="app">
    <label for="aaa">
        <div class="row">
            <div class="col-sm-12" >
        <?php foreach ($item_dataProvider as $item):?>
            <div class="col-sm-3 col-xs-6 box_row "  >
                 <!-- 产品 显示框 -->
                <div class="box_item thumbnail"  style="width:110%; margin-bottom: 10px;">

                    <a href="<?= Url::base()?>/item/view?id=<?= $item->id ?>">

                        <!-- 产品：图片 显示框 -->
                        <div class="row item_image" >
                            <img src="<?=  $item->imageUrl ?>" class="img-responsive center-block"  />
                        </div>

                        <!-- 产品：名字 显示框 -->
                        <div class="row item_name">
                            <?= $item->name ?>

                        </div>

                        <!-- 产品：购买的按钮 -->
                        <div class="row" style=" margin-top:-5px;">
                            <span class="item_price" >
                                <?= $item->pricing ?>
                            </span>
                        </div>
                    </a>
                    <?= $form->field($item, 'id')->checkbox([ 'label'=>'','style'=>'margin-top:-15px;','v-model'=>"selected",'value'=>$item->id]) ?>
                        <input type="checkbox"  id='pro' name="ok[]" value="<?= $item->id?>" v-model="selected"  style="display:none" />
                </div>
            </div>
        <?php endforeach; ?>

        </div>
    </div>
    </label>
    <input type="text"   name="store_id" value="<?= $store_id?>"  style="display:none" />
     <!-- <button v-on:click="greet" class="glyphicon glyphicon-shopping-cart btn btn-primary ">cart  <span class="badge">{{selected.length}}</span></button><br /><br /> -->
     <?= Html::submitButton('cart  <span class="badge">{{selected.length}}</span>', ['class' => 'glyphicon glyphicon-shopping-cart btn btn-primary', ]) ?><br /><br />
</div>
<?php ActiveForm::end(); ?>



<div class="row">
    <div class="col-sm-12">
    <?php
        echo LinkPager::widget([
        'pagination' => $pages,
        'maxButtonCount' => 5,//最多显示的几页
        'firstPageLabel'=>'First',//去到第一页
        'prevPageLabel'=>'Prev',//返回上一页
        'nextPageLabel'=>'Next',//下一页
        'lastPageLabel'=>'Last',//去到最后一页
       ]);?>
      </div>
</div>
