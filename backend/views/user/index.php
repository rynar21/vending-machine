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
                'template' => '{Staff}{Supervisor}{Revoke}',
                'buttons' => [
                    // 'Staff' => $this->Assign('staff', $id),
                    // 'Supervisor' => $this->Assign('supervisor', $id),
                    // 'Revoke' => $this->Revoke($role, $id)

                    'Staff' => function($url, $model, $id)
                    {
                        return Html::a('Staff', ['user/assign'], ['class' => 'btn btn-success']);
                    },
                    'Supervisor' => function($url, $model, $id)
                    {
                        return Html::a('Supervisor', ['user/assign'], ['class' => 'btn btn-success']);
                    },
                    'Revoke' => function($url, $model, $id)
                    {
                        return Html::a('Revoke', ['user/assign'], ['class' => 'btn btn-success']);
                    },

                ],
            ],
          ],
    ]); ?>


</div>
