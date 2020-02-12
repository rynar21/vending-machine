<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

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
                    Html::a('detailed', ['store/store_detailed', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6 ']).
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
                    Html::a('Add/update', ['store/add_update', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6']).
                    Html::a('Revoke', ['store/manager_revoke', 'id' => $model->id], ['class' => 'btn btn-sm  btn-primary col-lg-6 ',
                    'data' => ['confirm' => 'Are you sure you want to revoke this manager?',],]).' </div>';
                  }
              ],
              [
                  'attribute'=>'Profit today',
                  'format' => 'raw' ,
                  'value' => function ($model)
                  {
                    return 'MYR:'.$model->profit_today;
                  }
              ],
              [
                  'attribute'=>'Yesterday earnings',
                  'format' => 'raw' ,
                  'value' => function ($model)
                  {
                    return 'MYR:'.$model->yesterday_earnings;
                  }
              ],
          ],
     ]); ?>

    <!-- PHP: 展示时间 -->
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at);
        $auth = Yii::$app->authManager;
        if ($auth->checkAccess(Yii::$app->user->identity->id,'user')) {
            $str =' none';
        };
        if ($auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str =' ';
        } ;
    ?>

    <!-- 显示商店拥有的盒子 -->
<div class="btn-group mr-2 pull-left" role="group" aria-label="Second group">

    <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-success','style'=>"display:"."$str"]) ?>
    <?= Html::a('Lockup Box', ['store/kaiqi','id' => $model->id ], ['class' => 'btn btn-primary','style'=>"display:"."$str"]) ?>
    <?= Html::a('Open Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-danger','style'=>"display:"."$str"]) ?>

</div>

    <div class="col-sm-12">
         <div class="row">

                 <?= GridView::widget([
                          'dataProvider' => $dataProvider,
                          'filterModel' => $boxSearch,
                           'columns' => [
                               ['class' => 'yii\grid\SerialColumn'],
                               [
                                   'label'=> 'Box Code',
                                   'format' => 'raw',
                                   'value' => function ($model)
                                   {
                                       return $model->boxcode;
                                   }
                               ],
                               [
                                   'attribute'=> 'status',
                                   'value' => 'statusText'
                               ],
                               [
                                 'attribute' => 'name',
                                 'value' => 'product.name'
                                 ],
                               'item.price:currency',
                               [
                                   'label'=>'Action',
                                   'format' => 'raw',
                                   'visible' => Yii::$app->user->can('admin'),
                                   'value' => function ($model)
                                   {
                                       return $model->action;
                                   }
                               ],
                           ],
                       ]); ?>
         </div>

    </div>

</div>
