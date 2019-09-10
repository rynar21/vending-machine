<?php

use yii\helpers\Html;
use yii\grid\GridView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="User-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
    </p>

    <?php //print_r(array_keys($roles));// echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id',
            'username',
            'email',
            [
                'attribute'=> 'status',
                'value' => 'statusText'
            ],
            [
                'header' => 'Roles',
                'value' => function($data) {
                    $roles = Yii::$app->authManager->getRolesByUser($data->id);
                    if ($roles) {
                        $array = array_keys($roles);
                      if (count($roles)>=2) {
                      return  ($array[1]);
                      }
                    } else {
                        return 'no roles';
                    }
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Role Assign',
                'template' => '{User} {Staff} {Supervisor} {Revoke}',
                'buttons' => [
                    'User' => function($url, $model, $id)
                    {
                        return Html::a('User', ['assign', 'role'=>'user','id'=>$id], ['class' => 'btn btn-primary']);
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
            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Action',
                'template' => '{Unsuspend} {Suspend} {Terminate}',
                'buttons' => [
                    'Suspend' => function($url, $model, $id)
                    {
                        return Html::a('Suspend', ['update-status','status'=> User::STATUS_SUSPEND, 'id'=>$id], ['class' => 'btn btn-danger']);
                    },

                    'Unsuspend' => function($url, $model, $id)
                    {
                        return Html::a('Unsuspend', ['update-status','status'=> User::STATUS_ACTIVE,'id'=>$id], ['class' => 'btn btn-primary']);
                    },

                    'Terminate' => function($url, $model, $id)
                    {
                        return Html::a('Terminate', ['update-status','status'=> User::STATUS_DELETED,'id'=>$id], ['class' => 'btn btn-danger']);
                    },
                ],
            ],
          ],
    ]); ?>



</div>
