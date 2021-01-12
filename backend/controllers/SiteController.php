<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\LoginForm;
use backend\models\SignUp;
use common\models\User;
use yii\helpers\Url;
use backend\models\ResendVerificationEmailForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use backend\models\VerifyEmailForm;
use backend\models\UserSearch;
use backend\models\AdminPasswordForm;
use backend\models\ChangePasswordForm;
use yii\web\NotFoundHttpException;
use common\models\SaleRecord;
use common\models\Item;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSales()
    {
        $labels   = [];
        $data     = [];
        $pricesum = [];
        $sk       = [];
        $kunum    = [];

        for ($i = 0; $i < 10 ; $i++)
        {
          $labels[] = date('Y-m-d ', strtotime(-$i.'days'));
          sort($labels);
        }

        for ($i = count($labels); $i >= 1 ; $i--)
        {
            $model_count = SaleRecord::find()->where([
                'between',
                'updated_at',
                strtotime(date('Y-m-d', strtotime(1 - $i . ' day'))),
                strtotime(date('Y-m-d', strtotime(2 - $i . ' day')))
            ])->andWhere([
                'status'=> SaleRecord::STATUS_SUCCESS
            ])->count();

            $data[] = $model_count;
        }

        for ($j = count($labels); $j >= 1 ; $j--)
        {
            $models = SaleRecord::find()
            ->where(['status' => 10])
            ->andWhere([
                'between',
                'created_at' ,
                strtotime(date('Y-m-d', strtotime(1-$j.' day'))),
                strtotime(date('Y-m-d', strtotime(2-$j.' day')))
            ])->all();

            $total = 0;

            foreach ($models as $model)
             {
                $model1 = Item::find()->where(['id' => $model->item_id])->all();
                    foreach ($model1 as $itemmodel )
                    {
                        $arr = $itemmodel->price ;
                        $total += $arr;
                    }
            }
              $pricesum[] = $total;
        }

        $s = Item::find()->where([
            'status' => Item::STATUS_SOLD
        ])->all();

        foreach ($s as $sum)
        {
            $sums[] = $sum->product->sku;
        }

        $kunum = (array_keys((array_count_values($sums))));
        $sk    = (array_values((array_count_values($sums))));

        for ($i = 0; $i <= count($kunum)-1; $i++)
        {
             $a[] = array($kunum[$i], $sk[$i]);
        }

        for ($i = 0; $i < count($kunum)-1 ; $i++)
        {
             array_multisort(array_column($a, '1'), SORT_DESC, $a);
        }

        $b      = array_slice($a, 0, 5);
        $type   = array_column($b, '1');
        $number = array_column($b, '0');

        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        if (Yii::$app->request->isAjax)
        {
            return [
                'labels'   => $labels,
                'data'     => $data ,
                'pricesum' => $pricesum,
                'sk'       => $sk,
                'kunum'    => $kunum,
                'type'     => $type,
                'number'   => $number,
                'code'     => 200,
            ];
        }
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // PmsLog::push(Yii::$app->user->identity->id,'system ','login');

            return  $this->redirect(['index']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Url::to(['site/login']));
    }
}
