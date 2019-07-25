<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Stores', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="store-view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('Update Store', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete Store', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this Store?',
                'method' => 'post',
            ],
        ]) ?>
        <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-default']) ?>
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

    <hr/>
    <?php /*foreach($box_dataProvider->getModels() as $box):?>
      <div class="col-sm-3" >
          <div style="border: 1px solid black; width: 150px;">
            <?php echo 'Box: '.$box->code; ?>
          </div>
      </div>
    <?php endforeach;**/ ?>

    <?php /*echo GridView::widget([
        'dataProvider' => $box_dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],
            'id',
            'code',
            'status',
            'store_id',
            //'item.id',
            'created_at:datetime',
            'updated_at:datetime',
            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]);*/ ?>

    <div class="containter">

    </div>


    <!-- PHP: 展示时间 -->
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at); ?>

    <?php echo $this->render('/box/_list', [
      'model' => $model,
    ]); ?>

</div>
