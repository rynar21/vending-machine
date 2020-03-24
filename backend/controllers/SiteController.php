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
use common\models\Box;
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
                'only' => ['logout', 'signup','login'],
                'rules' => [
                    [
                        'actions' => ['login', 'error','test','logout','changepassword','captcha'],
                        'allow' => true,

                    ],
                    [
                        'actions' => ['login','captcha'],
                        'allow' => true,
                        'roles' => ['?'],
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
                        'actions' => ['index','sales','ajax','posturl','Store_sales','boxstatus'],
                        'allow' => true,
                        //'roles' => ['ac_read'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'checker' => [
               'class' => 'backend\libs\CheckerFilter',
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
                'backColor'=>0x16589,//背景颜色
                'maxLength' => 4, //最大显示个数
                'minLength' => 4,//最少显示个数
                'padding' => 5,//间距
                'height'=>34,//高度
                'width' => 130,  //宽度
                'foreColor'=>0xffffff,     //字体颜色
                'offset'=>4,  //设置字符偏移量 有效果
                //'controller'=>'login',        //拥有这个动作的controller
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
            for ($i=0; $i < 10 ; $i++) {
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
                $models = SaleRecord::find()
                ->where(['status' => 10])
                ->andWhere([
                    'between',
                    'created_at' ,
                    strtotime(date('Y-m-d',strtotime(1-$j.' day'))),
                    strtotime(date('Y-m-d',strtotime(2-$j.' day')))
                ])
                ->all();
                $total = 0;
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
            // print_r($pricesum);
            // die();
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
             for ($i=0; $i <count($kunum)-1 ; $i++)
              {
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

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
      $model = new LoginForm();

      if ($model->load(Yii::$app->request->post()) && $model->login()) {

          //使用session和表tbl_admin_session记录登录账号的token:time&id&ip,并进行MD5加密
          $id = Yii::$app->user->id;     //登录用户的ID
          $username = Yii::$app->user->identity->username;; //登录账号
          $ip = Yii::$app->request->userIP; //登录用户主机IP
          $token = md5(sprintf("%s&%s&%s",time(),$id,$ip));  //将用户登录时的时间、用户ID和IP联合加密成token存入表

          $session = Yii::$app->session;
          $session->set(md5(sprintf("%s&%s",$id,$username)),$token);  //将token存到session变量中
          //存session token值没必要取键名为$id&$username ,目的是标识用户登录token的键，$id或$username就可以

          $model->insertSession($id,$token);//将token存到tbl_admin_session
          //获取当前登录用户的IP地址。
          // $dz=  Yii::$app->request->serverName;
          // Yii::$app->slack->Posturl([
          //     'url'=>'https://forgetof.requestcatcher.com',
          //     'data'=>[
          //             'ip'=>$dz,
          //     ],
          // ]);
         // return $this->goBack();
          return $this->redirect(Url::to(['store/index']));//去到用户所拥有的店
      }
     // return $this->render('login', ['model' => $model,]);
      else {
          return $this->render('login', [
              'model' => $model,
               //Yii::$app->session->setFlash('error', 'Your account has already been logged in elsewhere'),
           ]
         );
        }

    }




    public function actionChangepassword()//changepassword
    {
        $model = new ChangePasswordForm();
        if (Yii::$app->user->identity!=null)
         {
            if( $model->load(Yii::$app->request->post()) && $model->changePassword())
            {
                 Yii::$app->user->logout();
                 return $this->redirect(Url::to(['site/login'],Yii::$app->session->setFlash('success', 'password has been updated.')));
            }
            else
            {
                return $this->render('changePassword',['model'=>$model]);
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
        return $this->redirect(Url::to(['site/login']));
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

                 return $this->redirect(Url::to(['site/login'],Yii::$app->session->setFlash('success', 'Your email has been confirmed!.')));
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
        //每间店的销售情况
        //$ID
    public function actionStore_sales()
    {
        $labels = [];
        $data = [];
        $pricesum=[];
        $sk=[];
        $kunum=[];
        $id=1;
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
              ->andWhere(['status'=> SaleRecord::STATUS_SUCCESS,'store_id'=> $id])
              ->count();
              $data[]=$model_count;
            }

            for ($j=count($labels); $j >=1 ; $j--) {
                $total = 0;
                $models = SaleRecord::find()
                ->where(['status' => 10,'store_id'=> $id])
                ->andWhere([
                    'between',
                    'created_at' ,
                    strtotime(date('Y-m-d',strtotime(1-$j.' day'))),
                    strtotime(date('Y-m-d',strtotime(2-$j.' day')))
                ])
                ->all();

                foreach ($models as $model)
                 {
                    $model1=Item::find()->where(['id'=>$model->item_id,'store_id'=>$id])->all();
                        foreach ($model1 as $itemmodel )
                         {
                            $arr= $itemmodel->price ;
                            $total += $arr;
                         }
                }
                  $pricesum[]=$total;
            }
            // print_r($pricesum);
            // die();
                $s = Item::find()->where(['status'=>Item::STATUS_SOLD,'store_id'=> $id])->all();
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
             for ($i=0; $i <count($kunum)-1 ; $i++)
              {
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

}
