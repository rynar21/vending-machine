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
                        'actions' => ['index'],
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
        $labels = [];
        $data = [];
        $data_amount=[];
        $count_data=[];
        $product=[];
        $data_type=[];
        $array = [];

        // $model_time = SaleRecord::find()->where(['status' => 10])->all();
        for ($i=0; $i <7  ; $i++)
        {
            $labels[] = date('"Y-m-d "', strtotime(-$i .'days'));
            sort($labels);
        }

        for ($j=count($labels)-1; $j >= 0; $j--)
        {
            $model_count = SaleRecord::find()
            ->where([
                'between',
                'updated_at',
                 strtotime(date('Y-m-d',strtotime(-$j.' day'))),
                 strtotime(date('Y-m-d',strtotime(1-$j.' day')))
             ])
            ->andWhere(['status'=> 10])
            ->count();
            $data[]=$model_count;
        }

        for ($j=count($labels)-1; $j >=0 ; $j--)
        {
             $total=0;
              $sale_record = SaleRecord::find()
              ->where(['status' => 10])
              ->andWhere([
                  'between',
                  'updated_at',
                  strtotime(date('Y-m-d',strtotime(-$j.' day'))),
                  strtotime(date('Y-m-d',strtotime(1-$j.' day')))])
              ->all();

                foreach ($sale_record as $model)
                {
                    $item=Item::find()->where(['id'=>$model->item_id])->all();

                    foreach ($item as $price )
                    {
                      $total+=$price->price ;
                    }
                }
                $data_amount[]=$total;
        }

        //For category Chart
        $data_item = Item::find()
                    ->Where([
                        'between',
                        'updated_at',
                        strtotime(date('Y-m-d',strtotime(-29 .' day'))),
                        strtotime(date('Y-m-d',strtotime(0 .' day')))
                    ])
                    ->where(['status'=>10])
                    ->all();
                    foreach ($data_item as $item)
                    {
                        $data_type[]=$item->product->category;
                        if (!array_key_exists($item->product->category,$count_data)) {
                            $count_data[$item->product->category]=1;
                        }
                        $count_data[$item->product->category]+=1;
                    }
                    // $count_data[] = count($data_item);
                // }
                // $count_data[] = count($data_type);
                for ($z=0; $z <=count($count_data)-1; $z++)
                {
                    // if (!empty($count_data[$z]&&$data_type[$z]))
                    // {
                        $array[]=array($count_data[$z],$data_type[$z]);
                    // }
                }
                for ($y=0; $y <count($count_data)-1 ; $y++) {
                    array_multisort(array_column($array,'0'),SORT_DESC,$array);
                }
                $count=array_slice($array,0);



        return $this->render('index', [
          'labels' => $labels,
          'data' => $data,
          'data_amount' => $data_amount,
          'count' => $count

      ]);
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
