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



<?php $form = ActiveForm::begin(['action' => ['box/gpay'],'method'=>'post',]); ?>
<div class="row">
    <div class="row">
        <div class="col-sm-offset-2 col-sm-10 headline font-color " style="font-size:20px;">
            Payment
        </div>
    </div>

    <hr />
    <div class="col-sm-12 " id='inner1'>
        <!-- 产品 输入 -->
        <div class=" outer-container col-lg-12 " >
            <!-- 产品 输入 -->
            <div class=" inner-containe col-lg-12  " >
        <?php foreach ($item_model as $item):?>
            <div class="col-sm-12 col-xs-12 " >
                 <!-- 产品 显示框 -->
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
    </div></div>
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
    <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8 " style="margin-top:-30px;margin-left:7vw;">
        <br/>
        <br/>
            <div class="row">
                <div class="col-sm-offset-4 col-sm-4 col-lg-offset-2 col-lg-8">
                    <h4>
                        Please follow the following steps to make payment:
                        <br/>
                        <br/>
                        1. Scan QR Code shown at the vending machine.
                        <br/>

                    </h4>
                </div>
            </div>
            <br/><br/>
            <?= Html::a('Cancel',  ['cancelb',  'salerecord_id'=>$salerecord_id,'store_id'=>$store_id],['class'=>"btn btn-default btn-cancel"], [
                'data' => [
                    'method' => 'post',
                    'params' => [
                        'params_key' => 'params_val'
                    ]
                ]
            ])?>
    </div>
</div>
<?php ActiveForm::end(); ?>
<style>

.outer-container{
                width: 100%;
                 height: 50vh;
                 position: relative;
                 overflow: hidden;
                 margin:0 auto;
     }
     .inner-containe{
         position: absolute;
         left: 0;
         top: 0;
         /* right: -17px; */
         bottom: 0;
         overflow-x: hidden;
         overflow-y: scroll;
     }
</style>
<!-- <script type="text/javascript">
    setTimeout("location.reload();",10000);
</script> -->
