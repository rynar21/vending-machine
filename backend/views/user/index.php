<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
// $this->params['breadcrumbs'][] = $this->title;
?>

<div class="User-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?php //print_r(array_keys($roles));// echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'tableOptions' => [
        'class' => 'table   table-bordered  table-hover ',
        ],
        'options' => [
            'class' => 'table-responsive',
        ],
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            //'username',
            [
               'attribute' =>'username',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search....'
                    ]
            ],
            //'email',
            [
               'attribute' =>'email',
                   'filterInputOptions' => [
                       'class'  => 'form-control',
                       'placeholder' => 'Search....'
                    ]
            ],
            [
                'attribute'=> 'status',
                'value' => 'statusText'
            ],
            [
                'header' => 'Roles',
                'format' => 'raw' ,
                'value' => function($data) {

                    $roles = Yii::$app->authManager->getRolesByUser($data->id);

                    if ($roles)
                    {
                        $array = array_keys($roles);

                        if (count($roles) >= 2)
                        {
                            return  ($array[1]);
                        }
                    }

                    if (empty($roles))
                    {
                        return 'No roles';
                    }

                    else
                    {
                        return '<span style="color:#CD0000">' .'no roles'.'';
                    }
                }
            ],

            // [   'class' => 'yii\grid\ActionColumn',
            //     'header' => '' ,
            //     'visible' => Yii::$app->user->can('supervisor'),
            //     'template' => '{update}',
            // ],
            [
                'attribute'=>'',
                'format' => 'raw' ,
                'headerOptions' =>['class'=>'col-lg-1',],
                'visible' => Yii::$app->user->can('supervisor'),
                'value' => function ($model)
                {
                  return Html::a('view', ['/user/view','id'=>$model->id]);
                }
            ],
          ],
    ]); ?>



</div>
