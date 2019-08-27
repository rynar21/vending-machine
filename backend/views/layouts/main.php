<?php
/* @var $this \yii\web\View */
/* @var $content string */
use backend\assets\AppAsset;

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
  <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <?php $this->registerCsrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>

    <body>
      <?php $this->beginBody() ?>

        <div class="wrap">
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
                ['label' => 'Store', 'url' => ['/store/index']],
                ['label' => 'Box', 'url' => ['/box/index?id=1']],
                ['label' => 'Item', 'url' => ['/item/index']],
                ['label' => 'Record', 'url' => ['/sale-record/index']],
                ['label' => 'Product', 'url' => ['/product/index']],
            ];
            }
            if (Yii::$app->user->isGuest) {
                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
            } else {
                $menuItems[] =
                // '<li>'
                    // . Html::beginForm(['/site/logout'], 'post')
                    // . Html::submitButton(
                    //     'Logout (' . Yii::$app->user->identity->username . ')',
                    //     ['class' => 'btn btn-link logout']
                    //
                    // )
                    // . Html::endForm()
                    // . '</li>';

                    [
                      'label' => 'Setting',
                      'items' => [
                        ['label' => 'Change Password', 'url' => '#'],
                        '<li class="divider"></li>',
                        ['label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                          'url' => ['/site/logout'],
                          'linkOptions' => ['data-method' => 'post']
                        ],
                      ],
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
                <p class="pull-left">&copy; <?= Html::encode(Yii::$app->name) ?> <?= date('Y') ?></p>
                <p class="pull-right"><?= Yii::powered() ?></p>
            </div>
        </footer>
      <?php $this->endBody() ?>
    </body>
  </html>
<?php $this->endPage() ?>
