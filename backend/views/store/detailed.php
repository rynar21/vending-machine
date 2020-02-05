<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;

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
            <?= Html::a('Cancel', ['store/view', 'id'=> $model->id], ['class' => 'btn btn-danger']) ?>
    </div>
    <?php echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'id',
              'name',
              'address',
              'contact',
              [
                  'attribute'=>'Manager',
                  'format' => 'raw' ,
                  'class' => 'text-center',
                  'value' => function ($model)
                  {
                    return $model->user;
                  }
              ],
              [
                  'attribute'=>'Total sales amount',
                  'format' => 'raw' ,
                  'value' => function ($model)
                  {
                    return 'MYR:'.$model->total_sales_amount;
                  },

              ],
               'prefix',
              [
                  'attribute'=>'image',
                  'value'=> $model->imageUrl,
                  'format'=>['image', ['width'=>'250', 'height'=>'250']]
              ],

              'created_at:datetime',
              'updated_at:datetime',
          ],
     ]); ?>
</div>
