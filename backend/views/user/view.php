<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->username;
?>

<?= Html::a('Change Password', ['user/reset-password','id'=>$model->id], ['class' => 'btn btn-sm btn-info pull-right']); ?>
<br><br>
<div class="col-sm-12">
     <div class="row">
    <?php echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                'username',
                'email',
                'created_at:datetime:Registration Time',
                [
                    'attribute'=>'Roles',
                    'format' => 'raw' ,
                    'value' => function($model) {

                        $roles = Yii::$app->authManager->getRolesByUser($model->id);

                        if ($roles)
                        {
                            $array = array_keys($roles);
                            return $array[0];
                        }

                        return "User";
                    }
                ],
                [
                    'attribute' => 'Permission',
                    'format' => 'raw' ,
                    'value' => function($model) {

                        $roles = Yii::$app->authManager->getPermissionsByUser($model->id);

                        if ($roles)
                        {
                            $array = array_keys($roles);
                            $one = null;
                            $two = null;
                            $three = null;
                            if (count($array) > 1) {
                                foreach ($array as $key => $value) {
                                    if ($key == 1) {
                                        $one =  $value;
                                    }
                                    if ($key == 2) {
                                        $two =  $value;
                                    }
                                    if ($key == 3) {
                                        $three =  $value;
                                    }
                                }
                            }

                            return $array[0]." ".$one." ".$two." ".$three;;
                        }

                        return '<span class="text-danger">' .'No Permission'.'';
                    }
                ],
                [
                    'attribute'=>'status',
                    'format' =>'raw',
                    'value' => function ($model)
                    {
                        if ($model->status == User::STATUS_ACTIVE) {
                            return '<span class="text-success">' .'Active'.'</span>';
                        }

                        return '<span class="text-danger">' .'Inactive'.'</span>';
                    }
                ],
            ],

    ]);
    ?>

<div class="User-form ">
    <div class="card">
        <?php $form = ActiveForm::begin(); ?>

        <div>
            <?= $form->field($model, 'roles')->radioList([
                'null'=>'User',
                'staff'=>'Staff',
                'supervisor'=>'Supervisor',
            ]) ?>
        </div>
        <div>
            <?= $form->field($model, 'status')->radioList([
                User::STATUS_INACTIVE => 'Inactive',
                User::STATUS_ACTIVE => 'Active',
            ]) ?>
        </div>
        <div>

            <label class="control-label">Allow Permission</label>
            <div>
                <?= $form->field($model, 'allow_product')->checkbox() ?>
                <?= $form->field($model, 'allow_record')->checkbox() ?>
                <?= $form->field($model, 'allow_report')->checkbox() ?>
                <?= $form->field($model, 'allow_assign')->checkbox() ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::a('Cancel', ['user/index',], ['class' => 'btn btn-default']) ?>
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>
