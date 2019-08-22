<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="User-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{User}{Staff}{Supervisor}{Revoke}',
                'buttons' => [
                    'User' => function($url, $model, $id)
                    {
                        return Html::a('User', ['assign', 'role'=>'user','id'=>$id], ['class' => 'btn btn-success']);
                    },

                    'Staff' => function($url, $model, $id)
                    {
                        return Html::a('Staff', ['assign' ,'role'=>'staff','id'=>$id], ['class' => 'btn btn-success']);
                    },

                    'Supervisor' => function($url, $model, $id)
                    {
                        return Html::a('Supervisor', ['assign','role'=>'supervisor','id'=>$id], ['class' => 'btn btn-success']);
                    },

                    'Revoke' => function($url, $model, $id)
                    {
                        return Html::a('Revoke', ['revoke','id'=>$id], ['class' => 'btn btn-danger']);
                    },
                ],
            ],
          ],
    ]); ?>


</div>
