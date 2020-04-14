<?php

use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Store';
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
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            //'name',
            [
               'attribute' =>'name',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search....'
                    ]
            ],
            [
                'attribute'=>'address',
                'format' => 'raw' ,
                'value' => function ($model)
                {
                  return '<div style="word-wrap: break-word;white-space: normal;word-break: break-all;">'.$model->address.'</div>';
                },
                'filterInputOptions' => [
                    'class'  => 'form-control',
                    'placeholder' => 'Search....'
                 ]
            ],
            [
              'label' => 'Manager',
              'attribute' => 'username',
              'visible' => Yii::$app->user->can('admin'),
              'value' => 'user.username',
              'filterInputOptions' => [
                  'class'  => 'form-control',
                  'placeholder' => 'Search....'
               ]
            ],
            //'contact',
            [
               'attribute' =>'contact',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search....'
                    ]
            ],
            [
                'format' => 'raw' ,
                'visible' => Yii::$app->user->can('admin'),
                'value' => function ($model)
                {
                  return Html::a('view', ['/store/view','id'=>$model->id]).' | '.Html::a('update', ['/store/update','id'=>$model->id]);
                }
            ],

        ],
    ]); ?>


</div>
