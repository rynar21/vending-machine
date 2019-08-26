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
        <?= Html::a('Sign Up', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php //print_r(array_keys($roles));// echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
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
          ],
    ]); ?>



</div>
