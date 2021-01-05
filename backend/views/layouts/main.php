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

        <div class="wrap ">
            <?php
            NavBar::begin([
                'brandLabel' => 'Vending Machine',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
            if (!Yii::$app->user->isGuest)
            {
            $menuItems = [
                ['label' => 'Home', 'url' => ['/site/index']],
                ['label' => 'User', 'url' => ['/user/index']],
                ['label' => 'Finance', 'url' => ['/finance/index']],
                ['label' => 'Store', 'url' => ['/store/index']],
                // ['label' => 'Box', 'url' => ['/box/index?id=1']],
                // ['label' => 'Item', 'url' => ['/item/index']],
                ['label' => 'Record', 'url' => ['/sale-record/index']],
                ['label' => 'Product', 'url' => ['/product/index'] ,'visible' => Yii::$app->user->can('admin')],
                ['label' => 'Change Password', 'url' => ['/site/changepassword'] ],
                ['label' => 'Logout', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
            ];
            }
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login'],
            ];

            }
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $menuItems,
            ]);
            NavBar::end();
            ?>

            <div class="container">
                <?= Breadcrumbs::widget([
                    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                ]) ?>
                <?= Alert::widget() ?>
                <?= $content ?>
            </div>
        </div>

        <footer class="footer">
            <div class="container">

            </div>
        </footer>
      <?php $this->endBody() ?>
    </body>
  </html>
<?php $this->endPage() ?>
