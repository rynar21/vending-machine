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
                        'actions'=>['change-password'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        // 'roles' => ['ac_read'],
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
        else
        {
            //$model->password = '';
            return $this->render('login', ['model' => $model,]);
        }
    }

    public function actionChangepassword($id)
    {

        $model = new AdminPasswordForm();

        $request = Yii::$app->request;

        if($request->isPost && $model->load(Yii::$app->request->post()) && $model->changePassword()){
            Yii::$app->user->logout();
            return $this->goHome();
        }else{
            return $this->render('changepassword',['model'=>$model]);
        }

        // return $this->render('changepassword', [
        //     'model' => $model,
        //
        // ]);


    }

    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        // throw new NotFoundHttpException('The requested page does not exist.');
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

    // public function actionTest()
    // {
    //     $form = new \frontend\models\SignupForm();
    //     $form->username = "admin5";
    //     $form->email = "admin@email5.com";
    //     $form->password = "admin5";
    //     $form->signup();
    //     print_r($form->errors);
    //
    //
    //     $auth = Yii::$app->authManager;
    //     // echo "<pre>";
    //     $admin = $auth->getRole('admin');
    //
    //     $auth->assign($admin,1);
    //
    //     // print_r($auth->getRoles());
    //     //
    //     // foreach ($auth->getRoles() as $role)
    //     // {
    //     //     echo $role->name . "<br>";
    //     // }
    // }
}
