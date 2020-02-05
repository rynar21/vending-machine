<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-index">
<!-- 标题 -->
    <h1 ><?= Html::encode($this->title) ?></h1>
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at);
        $auth = Yii::$app->authManager;
        if ($auth->checkAccess(Yii::$app->user->identity->id,'user')) {
            $str =' none';
        };
        if ($auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str =' ';
        } ;
    ?>
    <!-- 创建 新商店 -->
    <p>
        <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success','style'=>"display:"."$str"]) ?>
    </p>

    <!-- 商店列表 -->
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            'name',
            'address',
            [
                'attribute'=>'Manager',
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return $model->user
                  .' <div class="btn-group mr-2 pull-right col-lg-9 " role="group" aria-label="Second group"> '.
                  Html::a('Add/update', ['store/add_update', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6']).
                  Html::a('Revoke', ['store/manager_revoke', 'id' => $model->id], ['class' => 'btn btn-sm  btn-primary col-lg-6 ',
                  'data' => ['confirm' => 'Are you sure you want to revoke this manager?',],]).' </div>';
                }
            ],
            'contact',
            // 'created_at:datetime',
            // 'updated_at:datetime',
            ['class' => 'yii\grid\ActionColumn' , 'template'=>'{view}'],
            [   'class' => 'yii\grid\ActionColumn',
                'header' => '' ,
                'visible' => Yii::$app->user->can('admin'),
                'template' => '{update}',
            ],
            // [   'class' => 'yii\grid\ActionColumn',
            //     'header' => '' ,
            //     'visible' => Yii::$app->user->can('admin'),
            //     'template' => '{delete}',
            // ],
        ],
    ]); ?>

</div>

<!-- <script type="text/javascript">
setTimeout(function() { location.reload(); }, 5000);


</script> -->
