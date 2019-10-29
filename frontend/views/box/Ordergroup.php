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
<script>
function turnoff(obj){
document.getElementById(obj).style.display="none";
}

function turnon(obj,e){
 document.getElementById(obj).style.display="block";
}
</script>


<?php $form = ActiveForm::begin(['action' => ['box/gpay'],'method'=>'post',]); ?>
<div class="row">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-10 headline">
            Payment
        </div>
    </div>

    <hr />
    <div class="col-sm-12 " id='inner1'>
        <!-- 产品 输入 -->

        <?php foreach ($item_model as $item):?>
            <div class="col-sm-12 col-xs-12 " >
                 <!-- 产品 显示框 -->
                 <?= Html::a('X',  ['box',  'id' => $item->id,'item_id'=>$id],['style'=>"float:right"], [
                     'data' => [
                         'method' => 'post',
                         'params' => [
                             'params_key' => 'params_val'
                         ]
                     ]
                 ])?>
                <div class=""style="width:100%; margin-bottom:2px;height:100px; box-shadow: 0px 2px 4px #CDCDB4;border: 1px solid #FFFFFF;">

                        <!-- 产品：图片 显示框 -->
                        <div class=" col-sm-4 col-xs-4 img-responsive center-block align-self-center" style="height:90%;margin-top:2px;">
                            <img src="<?=  $item->imageUrl ?>" class="img-responsive center-block" style="width:100px;height:100%;"/>
                        </div>

                        <!-- 产品：名字 显示框 -->
                        <div class="col-sm-4 col-xs-4 ">
                            <?= $item->name ?>
                        </div>

                        <!-- 产品：购买的按钮 -->
                        <div class="col-sm-3 col-xs-3 ">
                            <span class="">
                                <?= $item->pricing ?>    <?= $item->id ?>
                            </span>
                        </div>
                        <div class="col-sm-1 col-xs-1 ">
                            <span class="">
                                x1
                            </span>
                        </div>

                </div>
            </div>

        <?php endforeach; ?>
        </div>

        <div class="col-sm-12">
            <div class="col-sm-12 col-xs-12 text-center" >
                <div style="white:100%;height:30px;
                /* box-shadow: 0px 0px 10px #CDCDB4; */
                /* border: 1px solid #FFFFFF; */
                ">
                    <!-- <div class="col-sm-10 col-xs-10 "></div> -->
                    <div class=" col-sm-1 col-xs-1 ">
                        <h4><?php echo 'Handle:RM'.number_format($sum,2) ;?></h4>
                    </div>
                    <div  class="col-sm-3 col-xs-3" ></div>
                </div>
            </div>
        </div>

</div>



<div class="row " >
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 text-center" style="margin-top:20px;">
        <br/>
        <br/>
            <!-- <input type="text"   name="id[]" value=" {'1','2'}"   style="display:none" /> -->
            <?= Html::a('Pay',  ['gpay',  'id' => $id],['class' => ' btn btn-primary btn-available '], [
                'data' => [
                    'method' => 'post',
                    'params' => [
                        'params_key' => 'params_val'
                    ]
                ]
            ])?>
            <br/><br/>
        <a href="<?= Url::base()?>/store/view?id=1"  class="btn btn-default btn-cancel" >
            Cancel
        </a>
    </div>
</div>
<?php ActiveForm::end(); ?>
