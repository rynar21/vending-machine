<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SignUp;
use backend\models\ResendVerificationEmailForm;
use backend\models\VerifyEmailForm;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedHttpException;
use yii\helpers\Url;


/**
 * userController implements the CRUD actions for user model.
 */
class UserController extends Controller
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
                    [  'actions' => ['create'],
                      'allow' => true,
                    ],
                    [  'actions' => ['update-status'],
                      'allow' => true,
                      'roles' => ['ac_update'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => true,
                        'roles'=> ['ac_user_read'],
                    ],
                    [
                        'actions' => ['assign'],
                        'allow' => true,
                        'roles' => ['ac_user_assign'],
                    ],
                    [
                        'actions' => ['revoke'],
                        'allow' => true,
                        'roles' => ['ac_user_revoke'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],

            'checker' => [
               'class' => 'backend\libs\CheckerFilter',
              ],

        ];
    }

    /**
     * Lists all user models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $user = $this->findModel($id);
        // $user = $user->user;

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    /**
     * Creates a new user model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SignUp();

        if ($model->load(Yii::$app->request->post()) && $model->SignUp())
        {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');

            return $this->redirect(Url::to(['site/login']));
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing user model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateStatus($status, $id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        // $dataProvider =$model->search(Yii::$app->request->queryParams);
        if (!$auth->checkAccess($id, 'admin'))
        {
            switch($status)
            {
                case User::STATUS_SUSPEND:
                    $model->status = User::STATUS_SUSPEND;
                    $model->save();
                    Yii::$app->session->setFlash('success', "Suspend Success.");
                    break;
                case User::STATUS_ACTIVE:
                    $model->status = User::STATUS_ACTIVE;
                    $model->save();
                    Yii::$app->session->setFlash('success', "Unsuspend Success.");
                    break;
                case User::STATUS_DELETED:
                    $model->status = User::STATUS_DELETED;
                    $model->save();
                    Yii::$app->session->setFlash('success', "Termimate Success.");
                    break;
                default:
                    Yii::$app->session->setFlash('danger', "User not active!");
                    break;
            }
        }

        else
        {
           Yii::$app->session->setFlash('danger', "Cannot edit admin");
        }
        return $this->actionView($id);
    }

    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */

    //To assign user Role
    public function actionAssign($role, $id)
    {
        $auth = Yii::$app->authManager;
        $user = User::findOne([
            'id' => $id,
            'status' => User::STATUS_ACTIVE
        ]);

        // IF EDITED USER STATUS IS ACTIVE.
        if($user)
        {
            //Current User is admin role.
            if ($auth->checkAccess(Yii::$app->user->identity->id, 'admin'))
            {
                if (!$auth->checkAccess($id, 'admin'))
                {
                    $auth->revokeAll($id);
                    $auth_role = $auth->getRole($role);
                    $auth->assign($auth_role, $id);
                    Yii::$app->session->setFlash('success', "Edit Success.");
                }
                else
                {
                    Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
                }

            }

            if ($auth->checkAccess(Yii::$app->user->identity->id, 'supervisor'))
            {

                if (!$auth->checkAccess($id, 'admin') && !$auth->checkAccess($id, 'supervisor'))
                {

                    if ($role != 'supervisor' && $role != 'admin')
                    {
                        $auth->revokeAll($id);
                        $auth_role = $auth->getRole($role);
                        $auth->assign($auth_role, $id);
                        Yii::$app->session->setFlash('success', "Edit Success.");
                    }
                    else
                    {
                        Yii::$app->session->setFlash('danger', "Unable to give supervisor authority");
                    }

                }

            }

        }
        else
        {
          Yii::$app->session->setFlash('danger', "Inactive account cannot assign Role");
        }

        return $this->actionView($id);
    }


    //To revoke user Role
    public function actionRevoke($id)
    {

        $auth = Yii::$app->authManager;

        if (!$auth->checkAccess($id, 'admin'))
        {
            $auth->revokeAll($id);
            Yii::$app->session->setFlash('success', "Revoke Success.");
        }
        else
        {
            Yii::$app->session->setFlash('danger', "Cannot Revoke Admin.");
        }

        //return $this->redirect(['index']);
        return $this->actionView($id);
    }

    /**
     * Finds the user model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return user the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = User::findOne($id)) !== null) {
    //         return $model;
    //     }
    //
    //     throw new NotFoundHttpException('The requested page does not exist.');
    // }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
