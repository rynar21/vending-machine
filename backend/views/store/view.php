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
        <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-success pull-right']) ?>
    </p>

    <?php echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'id',
              'name',
              'address',
              'contact',
              'created_at:datetime',
              'updated_at:datetime',
          ],
     ]); ?>

     <!-- 显示商店的图片-->
     <?php
     if($model->image == '')
     {
         $model->image = '/mel-img/store.jpg';
     }
     ?>
    <img src="<?php echo Url::base().$model->image; ?>"/>

    <hr/>

    <!-- PHP: 展示时间 -->
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at); ?>

    <!-- 显示商店拥有的盒子 -->
    <div class="row">
        <h3 class="col-sm-12">
            Available Boxes
        </h3>
    </div>

    <div class="col-sm-12">
        <?php echo $this->render('/box/_list', [
            'model' => $model ,
        ]); ?>
    </div>

</div>
