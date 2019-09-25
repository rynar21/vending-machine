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
                'corsFilter' => [
                'class' => \yii\filters\Cors::className(),
                'cors' => [
                    // restrict access to
                    'Access-Control-Allow-Origin' => ['*'],
                    // Allow only POST and PUT methods
                    'Access-Control-Request-Method' => ['POST', 'HEAD','GET'],
                    // Allow only headers 'X-Wsse'
                    'Access-Control-Request-Headers' => ['*'],
                    // Allow credentials (cookies, authorization headers, etc.) to be exposed to the browser
                    'Access-Control-Allow-Credentials' => true,
                ],
            ],
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
                        'actions' => ['index','data','curl-post'],
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
        return $this->render('index');
    }

    public function actionData()
    {
        $labels = [];
        $data = [];
        $data_amount=[];
        $count_data=[];
        $data_keys=[];
        $data_values=[];
        $array = [];

        // $model_time = SaleRecord::find()->where(['status' => 10])->all();
        for ($i=0; $i <7  ; $i++)
        {
            $labels[] = date('Y-m-d', strtotime(-$i .'days'));
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
                //Case:one
                    foreach ($data_item as $item)
                    {
                        $data_keys[]=$item->product->category;
                    }
                    $count_data=array_count_values($data_keys);
                //Case:two
                    // foreach ($data_item as $item)
                    // {
                    //     $data_keys[]="'".$item->product->category."'";
                    //     if (!array_key_exists($item->product->category,$count_data))
                    //     {
                    //         $count_data[$item->product->category]=0;
                    //     }
                    //     $count_data[$item->product->category]+=1;
                    // }
                    //
                    $data_values=array_values($count_data);
                    $data_keys=array_keys($count_data);
                    //Case:one
                    // $data_keys=array_keys(array_flip(array_unique($data_keys)));
                    // for ($z=0; $z <=count($count_data)-1; $z++)
                    // {
                    //     if (!empty($data_values[$z]&&$data_keys[$z]))
                    //     {
                    //         $array[]=array($data_values[$z],$data_keys[$z]);
                    //     }
                    // }
                    // for ($y=0; $y <count($count_data)-1 ; $y++) {
                    //     array_multisort(array_column($array,'0'),SORT_DESC,$array);
                    // }
                    // $data_values=array_column($data_values,'0');
                    // $data_keys=array_column($data_keys,'1');

                    //Case:two
                    for ($i=0; $i < count($data_values); $i++) {
                        for ($j=0; $j <= $i; $j++) {
                            if ($data_values[$i]>$data_values[$j]) {
                                //对值排序
                                $array=$data_values[$i];
                                $data_values[$i]=$data_values[$j];
                                $data_values[$j]=$array;
                                //对键排序
                                $array=$data_keys[$i];
                                $data_keys[$i]=$data_keys[$j];
                                $data_keys[$j]=$array;
                            }
                        }
                    }
                    $data_values=array_slice($data_values,0,5);
                    $data_keys=array_slice($data_keys,0,5);
        if (Yii::$app->request->isAjax)
        {
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
              'labels' => $labels,
              'data'=>$data,
              'data_amount' => $data_amount,
              'data_keys'=>$data_keys,
              'data_values'=>$data_values,
              // 'code' => 100,
          ];
        }
    }


    // $this->actionCurlPost([
    //     'data' => [
    //         'text' => 'Hello, World!'
    //     ],
    //     'text' => 'test'
    // ]);

    public function actionCurlPost($config)
    {
        $url = ArrayHelper::getValue($config, 'url', 'https://hooks.slack.com/services/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');
        $data = ArrayHelper::getValue($config, 'data', []);
        $ch = curl_init(); //初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
        curl_setopt ($ch, CURLOPT_HTTPHEADER, array('Content-type:application/json'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST"); //设置请求方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));//设置提交的字符串
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        //禁用后cURL将终止从服务端进行验证。使用CURLOPT_CAINFO选项设置证书使用CURLOPT_CAPATH选项设置证书目录 如果CURLOPT_SSL_VERIFYPEER(默认值为2)被启用，CURLOPT_SSL_VERIFYHOST需要被设置成TRUE否则设置为FALSE。
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        //1 检查服务器SSL证书中是否存在一个公用名(common name).公用名(Common Name)一般来讲就是填写你将要申请SSL证书的域名 (domain)或子域名(sub domain)。2 检查公用名是否存在，并且是否与提供的主机名匹配。
        $output = curl_exec($ch);
        curl_close($ch);
        return json_decode($output,true);
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
