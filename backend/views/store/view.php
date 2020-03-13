<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;
use common\models\Store;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $model common\models\Store */
$this->title = $model->name;
?>

<div class="store-view">
    <!-- 显示 店名为标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title);
            //echo $md;
            ?>
    </div>
    <?php echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              [
                  'attribute'=>'name',
                  'format' => 'raw' ,
                   'visible' => Yii::$app->user->can('admin'),
                  'value' => function ($model)
                  {
                    return $model->name.' <div class="btn-group mr-2 pull-right col-lg-4 " role="group" aria-label="Second group"> '.
                    Html::a('Detailed', ['store/store_detailed', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6 ']).
                    Html::a('Sales', ['site/index', ], ['class' => 'btn btn-sm  btn-primary col-lg-6  ']).' </div>';
                  }
              ],
              [
                  'attribute'=>'Manager',
                  'format' => 'raw' ,
                  'visible' => Yii::$app->user->can('admin'),
                  'value' => function ($model)
                  {
                    return $model->User_name
                    .' <div class="btn-group mr-2 pull-right col-lg-4 " role="group" aria-label="Second group"> '.
                    Html::a('Add', ['store/add_update', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6']).
                    Html::a('Revoke', ['store/manager_revoke', 'id' => $model->id], ['class' => 'btn btn-sm  btn-primary col-lg-6 ',
                    'data' => ['confirm' => 'Are you sure you want to revoke this manager?',],]).' </div>';
                  }
              ],
              [
                  'attribute'=>'Profit today',
                  'format' => 'currency' ,
                  'value' => function ($model)
                  {
                    return $model->profit_today;
                  }
              ],
              [
                  'attribute'=>'Yesterday earnings',
                  'format' => 'currency' ,
                  'value' => function ($model)
                  {
                    return $model->yesterday_earnings;
                  }
              ],
              [
                  'attribute'=>'Statement inquiry',
                  'format' => 'raw' ,
                  'value' => function ($model)
                  {
                    return
                  '<div class="btn-group mr-2 pull-left col-lg-12 " role="group" aria-label="Second group">
                  <form method="GET" action="http://localhost/vending-machine/backend/web/finance/datecheck_store">
                      <input name="date1"  type="date" min="2000-01-02"  class=" col-sm-3" >
                      <div class="col-sm-1 text-center">-</div>
                      <input name="date2"  type="date" min="2000-01-02" class=" col-sm-3" >
                      <input name="store_id" value='.$model->id.' type="hidden"  >
                      <input type="submit" name="submit" value="Search" class=" btn btn-sm btn-primary col-sm-2 pull-right">
                  </form>
                  </div>';
                  }
              ],
          ],
     ]); ?>

    <!-- PHP: 展示时间 -->


    <?php  //echo Yii::$app->formatter->asDateTime($model->created_at);
         $auth = Yii::$app->authManager;
        if ($auth->checkAccess(Yii::$app->user->identity->id,'user')) {
            $str =' none';
        };
        if ($auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str =' ';
        } ;
        if ($model->status == Store::STATUS_IN_MAINTENANCE) {
            $strr = true;
        }
        if ($model->status != Store::STATUS_IN_MAINTENANCE) {
            $strr = false;
        }
    ?>

    <div class="btn-group mr-2 pull-left" role="group" aria-label="Second group" style="display:<?=$str?>">
        <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-sm btn-info',]) ?>
    <?php if ($model->status != Store::STATUS_IN_MAINTENANCE): ?>
            <?= Html::a('Lock ', ['store/lockup_box','id' => $model->id ], ['class' => 'btn btn-sm btn-primary',]) ?>
    <?php endif; ?>
    <?php if ($model->status == Store::STATUS_IN_MAINTENANCE): ?>
            <?= Html::a('Release ', ['store/open_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger',]) ?>
    <?php endif; ?>
    </div>
    <!-- 显示商店拥有的盒子 -->


    <div class="col-sm-12">
         <div class="row">

                 <?= GridView::widget([
                          'dataProvider' => $dataProvider,
                          'filterModel' => $boxSearch,
                           'columns' => [
                               ['class' => 'yii\grid\SerialColumn'],
                               [
                                   'attribute'=> 'code',
                                   'label'=> 'Box Code',
                                   'format' => 'raw',
                                   'headerOptions' =>['class'=>'col-lg-2',],
                                   'value' => function ($model)
                                   {
                                       return $model->boxcode;
                                   }
                               ],
                               [
                                   'attribute'=> 'status',
                                   'label' =>'Status',
                                   'value' => 'statusText'
                               ],
                               [
                                 'attribute' => 'name',
                                 'label'=> 'Item',
                                 'value' => 'product.name'
                               ],
                               'item.price:currency',
                               [
                                   'label'=>'Action',
                                   'format' => 'raw',
                                   'visible' => $strr,
                                   'value' => function ($model)
                                   {
                                       return $model->action;
                                   }
                               ],
                               [
                                    'label'=>'History',
                                   'format' => 'raw' ,
                                   'headerOptions' =>['class'=>'col-lg-1',],
                                   'visible' => Yii::$app->user->can('supervisor'),
                                   'value' => function ($model)
                                   {
                                     return Html::a('Item ', ['/store/box_item','box_id'=>$model->id,'store_id'=>$model->store_id]).
                                     ' | '. Html::a('Order ', ['/sale-record/onebox_salerecord','box_id'=>$model->id,'store_id'=>$model->store_id]);
                                   }
                               ],
                           ],
                       ]); ?>
         </div>

    </div>

</div>
