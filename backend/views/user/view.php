<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

// $this->title = $model->id;
// $this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['index']];
// $this->params['breadcrumbs'][] = $this->title;
// \yii\web\YiiAsset::register($this);
$this->title = $model->username;
?>

<div class="row">
    <h1 class="col-sm-12">
        <?= Html::a('Back', ['user/index',], ['class' => 'btn btn-primary']) ?>
</div>

<div class="col-sm-12">
     <div class="row">
    <?php echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                'id',
                'username',
                'email',
                [
                    'attribute'=>'status',
                    'format' => 'raw' ,
                     'visible' => Yii::$app->user->can('admin'),
                    'value' => function ($model)
                    {
                      return $model->statustext;
                    }
                ],
                [
                    'attribute'=>'Roles',
                    'format' => 'raw' ,
                    'value' => function($data) {
                        $roles = Yii::$app->authManager->getRolesByUser($data->id);
                        if ($roles) {
                            $array = array_keys($roles);
                          if (count($roles)>=2) {
                          return  ($array[1]);
                          }
                        }
                        if (empty($roles)) {
                            return 'No roles';
                        }else {
                            return '<span style="color:#CD0000">' .'no roles'.'';
                        }
                    }
                ],

                [
                    'attribute'=>'Action',
                    'format' => 'raw' ,
                    'visible' => Yii::$app->user->can('admin'),
                    'value' => function ($model)
                    {
                       return ' <div class="btn-group mr-2 pull-left col-lg-6 " role="group" aria-label="Second group"> '.
                       Html::a('Suspend', ['update-status','status'=> User::STATUS_SUSPEND, 'id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-danger']).
                        Html::a('Unsuspend', ['update-status','status'=> User::STATUS_ACTIVE,'id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-primary']).
                        Html::a('Terminate', ['update-status','status'=> User::STATUS_DELETED,'id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-danger']).
                        '</div>';
                    }
                ],

                [
                    'attribute'=>'Role Assign',
                    'format' => 'raw' ,
                    'visible' => Yii::$app->user->can('supervisor'),
                    'value' => function ($model)
                    {
                       return ' <div class="btn-group mr-2 pull-left col-lg-6 " role="group" aria-label="Second group"> '.
                       Html::a('User', ['assign', 'role'=>'user','id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-primary']).
                        Html::a('Staff', ['assign' ,'role'=>'staff','id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-primary']).
                        Html::a('Supervisor', ['assign','role'=>'supervisor','id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-primary']).
                        Html::a('Revoke', ['revoke','id'=>$model->id], ['class' => 'btn btn-sm  col-lg-3 btn-danger']).'</div>';
                    }
                ],
            ],

    ]);
    ?>

</div></div>
