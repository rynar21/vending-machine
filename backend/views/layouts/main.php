<?php
/* @var $this \yii\web\View */
/* @var $content string */
use common\assets\AppAsset;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;
use kartik\sidenav\SideNav;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
      <?php $this->beginBody() ?>

      <div class="grid grid-2" style="grid-template-rows:100vh;padding-right:10px;">
        <div class="" style="padding:0px;background-color:#222;overflow-y: auto;">
            <div class="navbar navbar-inverse" role="navigation">

            <?php
                $items = [
                    ['label' => 'Vending Machine', 'url' => ['/store/index'], 'visible' => Yii::$app->user->can('staff')],
                    ['label' => 'Sale Records', 'url' => ['/sale-record/index'], 'visible' => Yii::$app->user->can('allowRecord')],
                    ['label' => 'Product Management', 'url' => ['/product/index'], 'visible' => Yii::$app->user->can('allowProduct')],
                    ['label' => 'User Management', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('allowAssign')],
                    ['label' => 'Financial Report', 'url' => ['/finance/index'], 'visible' => Yii::$app->user->can('allowReport')],
                    ['label' => 'Change Password', 'url' => ['/user/change-password']],
                    ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                ];
            
                echo Nav::widget([
                    'options' => ['class' => 'nav'],
                    'items' => $items
                ]);
            ?>
            </div>
        </div>
            <div style="grid-column:2/7;overflow-y: auto;padding-top:8px">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

       
      <?php $this->endBody() ?>
    </body>
  </html>
<?php $this->endPage() ?>
