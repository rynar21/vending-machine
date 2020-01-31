<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Store */
$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>

<div class="store-view">
    <!-- 显示 店名为标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <p>
        <?= Html::a('Update Store', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete Store', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Store?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              // 'id',
              'name',
              'address',
              'contact',
              // 'prefix',

              [
                  'attribute'=>'image',
                  'value'=> $model->imageUrl,
                  'format'=>['image', ['width'=>'250', 'height'=>'250']]
              ],

              // 'created_at:datetime',
              // 'updated_at:datetime',
          ],
     ]); ?>

    <hr/>

    <!-- PHP: 展示时间 -->
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at); ?>

    <!-- 显示商店拥有的盒子 -->
    <div class="row">
        <h3 class="col-sm-12">
            Available Boxes
        </h3>
    </div>
    <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-success pull-left']) ?>
    <?= Html::a('Edit Box', ['store/edit', 'id' => $model->id],
        [
        'class' => 'btn btn-primary',
        'data-method' => 'POST',
        'data-params' => [
            'modify' => true,
        ],
    ]) ?>
    <?= Html::a('Close Edit', ['store/edit', 'id' => $model->id],
        [
        'class' => 'btn btn-danger',
        'data-method' => 'POST',
        'data-params' => [
            'modify' => 0,
        ],
    ]) ?>
    <div class="col-sm-12">
        <?php
         // echo $this->render('/box/_list', [

            // 'model' => $model ,
            // 'query'=>$query,
            // 'dataProvider' => $dataProvider,
        // ]);
         ?>

         <div class="row">

                 <?= GridView::widget([
                          'dataProvider' => $dataProvider,
                          'filterModel' => $boxSearch,
                           'columns' => [
                               ['class' => 'yii\grid\SerialColumn'],
                               // 'id',
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
                               // 'status',
                               [
                                 'attribute' => 'name',
                                 'value' => 'product.name'
                                 ],
                               'item.price:currency',
                               // 'created_at:datetime',
                               // 'updated_at:datetime',
                               [
                                   'label'=>'Action',
                                   'format' => 'raw',
                                   'visible' => $modify,
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
<!-- -->
