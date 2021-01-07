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

        <style>
        [v-cloak] {display:none;}
        .navbar {
            color: #FFF;
            border: none;
        }
        .nav > li > a{
            border:none;
            color: #FFF;
            text-decoration: none;
        }
        .nav > li > a:hover, .nav > li > a:active, .nav .open > a:focus {
            border:none;
            color:#fff;
            background-color: #666;
        }
        .nav .open > a, .nav .open > a:hover, .nav .open > a:focus {
            background-color:  #666;
            border-color: #337ab7;
        }
        .dropdown-menu > li > a:hover, .nav > .active > a {
            background-color:  #333333;
            color: #fff;
        }
        .dropdown-menu > .active > a{
            background-color:  #fff;
            color: black;
        }
        .dropdown-menu > .active > a:hover{
            background-color:  #333333;
            color:#fff;
            text-decoration: none;
        }

        .grid {
            display: grid;
            grid-gap: 8px;
            grid-template-columns: 1fr;
            grid-template-rows: min-content;
        }

        .grid-2 {
            grid-template-columns: repeat(6, 1fr);
        }

        .grid-3 {
            grid-template-columns: repeat(4, 1fr);
        }

        .grid-4 {
            grid-template-columns: repeat(3, 1fr);
        }

        .grid-6 {
            grid-template-columns: repeat(2, 1fr);
        }

        @media (min-width: 768px) {
            .grid-sm-4 {
                grid-template-columns: repeat(3, 1fr);
            }
        }

    </style>
    </head>

    <body>
      <?php $this->beginBody() ?>

      <div class="grid grid-2" style="grid-template-rows:100vh;padding-right:10px;">
        <div class="" style="padding:0px;background-color:#222;overflow-y: auto;">
            <div class="navbar navbar-inverse" role="navigation">

            <?php
                $items = [
                    ['label' => 'User Management', 'url' => ['/user/index'], 'visible' => Yii::$app->user->can('allowAssign')],
                    ['label' => 'Finance', 'url' => ['/finance/index'], 'visible' => Yii::$app->user->can('allowReport')],
                    ['label' => 'Vending Machine', 'url' => ['/store/index'], 'visible' => Yii::$app->user->can('staff')],
                    ['label' => 'Record', 'url' => ['/sale-record/index'], 'visible' => Yii::$app->user->can('allowRecord')],
                    ['label' => 'Product', 'url' => ['/product/index'], 'visible' => Yii::$app->user->can('allowProduct')],
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
