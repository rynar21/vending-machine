<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
$this->title = 'Login';
// $this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>Please fill out the following fields to login:</p>

    <div class="row">
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
                <?= $form->field($model, 'username')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'password')->passwordInput() ?>

                <?= $form->field($model, 'rememberMe')->checkbox() ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div id= "verifyCode" class="col-lg-3  col-xs-3">{image}</div>
                    <div class="  col-lg-9  col-xs-9">{input}</div></div>',
                    // 'imageOptions'=> [
                    //                     'id'=>'captchaimg',
                    //                     'title'=>'换一个',
                    //                     'alt'=>'换一个',
                    //                     'style'=>'cursor:pointer;margin-left:25px;'],
                ]) ?>




                <div style="color:#999;margin:1em 0">
                    <?= Html::a('Forgot Password?', ['site/request-password-reset']) ?>
                    <br>
                     <?= Html::a('Activate Account', ['site/resend-verification-email']) ?>
                    <!-- Need new verification email? -->
                     <?= "" //Html::a('Resend', ['site/resend-verification-email']) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                    <?= Html::a('Sign Up', ['user/create'], ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<?php
// $c=!Yii::$app->authManager->checkAccess(1,'user');
// if ($c) {
//     echo'000';
// }
// else {
//     echo'111';
// }
?>
