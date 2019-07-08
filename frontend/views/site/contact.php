<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = 'Contact';
?>

<div class="site-contact">
  <div class="container-fluid">
    <div class="col-sm-6 col-sm-offset-3">
      <h1><?= Html::encode($this->title) ?> Us</h1>
    </div>
  </div>

    <div class="container">
        <div class="col-sm-6 col-sm-offset-3">
            <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
              <div class="row">
                <div class="col-xs-6">
                <?= $form->field($model,'firstName') ?>
                </div>
                <div class="col-xs-6">
                <?= $form->field($model, 'lastName') ?>
                </div>
              </div>
                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'btn btn-primary btn-block', 'name' => 'contact-button', ]) ?>
                </div>

            <?php ActiveForm::end(); ?>
          </div>
        </div>

    <div class="container">
      <div class="col-sm-6 col-sm-offset-3">

            <div class="container">
              <div class="row">
                <p>Store name</p>
                <h4><?= $model3->store_name ?></h4>
                <br>
              </div>
              <div class="row">
                Address<br>
                <h4><?= $model3->store_description ?></h4><br>
              </div>
              <div class="row">
                Contact Number<br>
                <h4>+0<?= $model3->store_contact ?></h4><br>
              </div>

            </div>
      </div>
    </div>
</div>
