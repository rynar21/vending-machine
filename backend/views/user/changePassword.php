<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \backend\models\ChangePasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Change password';

?>
<div class="site-change-password">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="card">
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'reset-password-form']); ?>

                <?= $form->field($model, 'password')->passwordInput(['placeholder'=> 'Current password']) ?>

                <?= $form->field($model, 'newPassword')->passwordInput(['placeholder'=> 'New password']) ?>

                <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder'=> 'Verify password']) ?>

                    <div class="form-group">
                        <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
