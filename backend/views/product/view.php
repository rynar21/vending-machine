<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Product */

$this->title = $model->name;
// $this->params['breadcrumbs'][] = ['label' => 'Products', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="product-view">

    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <!-- Html::a('Update', ['update','id'=>$model->id], ['class' => 'btn btn-primary']) -->
        <?= Html::a('Back to Listing', ['index'], ['class' => 'btn btn-primary']) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [

            'id',
            'sku',
            'name',
            'description',
            'price:currency',
            'cost:currency',
            'image',
            [
              'attribute'=>'image',
              'value'=> $model->imageUrl,
              'format'=>['image', ['width'=>'250', 'height'=>'250']],
              //['width'=>'400', 'height'=>'300']
            ],
            'created_at:datetime',
            'updated_at:datetime',
        ],
    ]) ?>

</div>
