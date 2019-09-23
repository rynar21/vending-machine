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
use common\models\Product;
use yii\helpers\BaseJson;
use yii\helpers\Json;



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
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error','test','logout','changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['request-password-reset','reset-password'],
                        'allow' => true,
                    ],
                    [
                        'actions'=>['verify-email','resend-verification-email'],
                        'allow' => true,
                    ],
                    [
                        'actions'=>['changepassword'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index','sales','ajax'],
                        'allow' => true,
                        'roles' => ['ac_read'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
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
        //return $this->redirect(['sales']);
        return $this->render('index');
    }


    public function actionSales()
    {
        $labels = [];
        $data = [];
        $pricesum=[];
        $sk=[];
        $kunum=[];

            for ($i=0; $i < 7 ; $i++) {
              $labels[] = date('Y-m-d ', strtotime(-$i.'days'));
              sort($labels);
            }

            for ($i=count($labels); $i >=1 ; $i--)
            {
              $model_count = SaleRecord::find()
              ->where([
                  'between',
                  'updated_at',
                  strtotime(date('Y-m-d',strtotime(1-$i.' day'))),
                  strtotime(date('Y-m-d',strtotime(2-$i.' day')))
               ])
              ->andWhere(['status'=> SaleRecord::STATUS_SUCCESS])
              ->count();
              $data[]=$model_count;
            }

            for ($j=count($labels); $j >=1 ; $j--) {
                $total = 0;
                $models = SaleRecord::find()
                ->where(['status' => 10])
                ->andWhere([
                    'between',
                    'created_at' ,
                    strtotime(date('Y-m-d',strtotime(1-$j.' day'))),
                    strtotime(date('Y-m-d',strtotime(2-$j.' day')))
                ])
                ->all();

                foreach ($models as $model)
                 {
                    $model1=Item::find()->where(['id'=>$model->item_id])->all();
                        foreach ($model1 as $itemmodel )
                         {
                            $arr= $itemmodel->price ;
                            $total += $arr;
                         }
                }
                  $pricesum[]=$total;
            }
                $s = Item::find()->where(['status'=>Item::STATUS_SOLD])->all();
                foreach ($s as $sum) {
                    $sums[]=$sum->product->sku;
                }
             //print_r(array_count_values($sums));

            $kunum =(array_keys((array_count_values($sums))));
            $sk = (array_values((array_count_values($sums))));
             for ($i=0; $i <=count($kunum)-1; $i++)
             {
                 $a[]=array($kunum[$i],$sk[$i]);
             }
             for ($i=0; $i <count($kunum)-1 ; $i++) {
                 array_multisort(array_column($a,'1'),SORT_DESC,$a);
             }
            $b=array_slice($a,0,5);
            $type = array_column($b,'1');
            $number = array_column($b,'0');

             \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            if (Yii::$app->request->isAjax) {
                return [
                    'labels' => $labels,
                    'data' => $data ,
                    'pricesum' => $pricesum,
                    'sk'=> $sk,
                    'kunum'=>$kunum,
                    'type'=>$type,
                    'number'=>$number,
                    'code'=> 200,
                ];
            }

    }
    public function actionAjax()
    {
          if(Yii::$app->request->post('test'))
          {
            $test = "Ajax Worked!";
            // do your query stuff here
          }else{
            $test = "Ajax failed";
            // do your query stuff here
          }
          // return Json
      return \yii\helpers\Json::encode($test);
    }



    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login())
        {
            //return $this->goBack();
            return $this->redirect(Url::to(['store/index']));
        }
            return $this->render('login', ['model' => $model,]);
    }

    public function actionChangepassword()
    {

        $model = new ChangePasswordForm();
        if (Yii::$app->user->identity!=null) {


            if( $model->load(Yii::$app->request->post()) && $model->changePassword()){
                // Yii::$app->user->logout();
                return $this->logout();
            }else{
                return $this->render('changepassword',['model'=>$model]);
            }
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
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

        return $this->actionLogin();
    }
    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->actionLogin();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->actionLogin();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->actionLogin();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * Verify email address
     *
     * @param string $token
     * @throws BadRequestHttpException
     * @return yii\web\Response
     */
    public function actionVerifyEmail($token)
    {
        try {
            $model = new VerifyEmailForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if ($user = $model->verifyEmail()) {
            if (Yii::$app->user->Logout($user)) {
                Yii::$app->session->setFlash('success', 'Your email has been confirmed!');
                return $this->actionLogin();
            }
        }

        Yii::$app->session->setFlash('error', 'Sorry, we are unable to verify your account with provided token.');
        return $this->actionLogout();
    }

    /**
     * Resend verification email
     *
     * @return mixed
     */
    public function actionResendVerificationEmail()
    {
        $model = new ResendVerificationEmailForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->actionLogout();
            }
            Yii::$app->session->setFlash('error', 'Sorry, we are unable to resend verification email for the provided email address.');
        }

        return $this->render('resendVerificationEmail', [
            'model' => $model
        ]);
    }

}
