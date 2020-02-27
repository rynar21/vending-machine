<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;

?>

<div class="store-detailed col-xs-4 col-sm-12">
    <!-- 显示 店名为标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::a('Back', ['store/view', 'id'=> $model->id], ['class' => 'btn btn-primary']) ?>
    </div>
    <?php echo DetailView::widget([
          'model' => $model,
          'attributes' => [
              'id',
              'name',
              'address',
              'contact',
              'user.username',
              [
                  'attribute'=>'Total sales amount',
                  'format' => 'currency' ,
                  'value' => function ($model)
                  {
                    return $model->total_sales_amount;
                  },

              ],
               'prefix',
              [
                  'attribute'=>'image',
                  'value'=> $model->imageUrl,
                  'format'=>['image', ['width'=>'250', 'height'=>'250']]
              ],
              'description',
              'created_at:datetime',
              'updated_at:datetime',
          ],
     ]); ?>
</div>
