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
                    [  'actions' => ['suspend','unsuspend'],
                      'allow' => true,
                      'roles' => ['ac_update'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['ac_delete'],
                    ],
                    [
                        'actions' => ['index', 'view'],
                        'allow' => Yii::$app->user->can('ac_user_read'),
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
        if ($model->load(Yii::$app->request->post()) && $model->SignUp()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
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
    public function actionSuspend($id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        if (!$auth->checkAccess($id,'admin')) {
            $model->status=User::STATUS_SUSPEND;
            $model->save();
            Yii::$app->session->setFlash('success', "Suspend Success.");
        }
        else {
             Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }

    public function actionUnsuspend($id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        if (!$auth->checkAccess($id,'admin')) {
            $model->status=User::STATUS_ACTIVE;
            $model->save();
            Yii::$app->session->setFlash('success', "Suspend Success.");
        }
        else {
             Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }
    /**
     * Deletes an existing user model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $auth = Yii::$app->authManager;
        $model = $this->findModel($id);
        if (!$auth->checkAccess($id,'admin')) {
            $model->status=User::STATUS_DELETED;
            $model->save();
            Yii::$app->session->setFlash('success', "Suspend Success.");
        }
        else {
             Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
        }
        return $this->render('index', [
            'model' => $model,
        ]);
    }


    //To assign user Role
    public function actionAssign($role, $id)
    {
        $auth = Yii::$app->authManager;
        // $str=$auth->getUserIdsByRole('admin');
        $current_id = Yii::$app->user->identity->id;
        if ($auth->checkAccess($current_id,'admin')) {
              if (!$auth->checkAccess($id,'admin')) {
                      $auth->revokeAll($id);
                      $auth_role = $auth->getRole($role);
                      $auth->assign($auth_role, $id);
                      Yii::$app->session->setFlash('success', "Edit Success.");
              }
              else {
                   Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
              }
          }
          if ($auth->checkAccess($current_id,'supervisor')) {
              if (!$auth->checkAccess($id,'admin')&&!$auth->checkAccess($id,'supervisor')) {
                  if ($role!='supervisor'&&$role!='admin') {
                      $auth->revokeAll($id);
                      $auth_role = $auth->getRole($role);
                      $auth->assign($auth_role, $id);
                      Yii::$app->session->setFlash('success', "Edit Success.");
                  }
                  else {
                     Yii::$app->session->setFlash('danger', "Unable to give supervisor authority");
                  }
              }
          }

            return $this->redirect(['index']);

}
    //To revoke user Role
    public function actionRevoke($id)
    {

        $auth = Yii::$app->authManager;
        if (!$auth->checkAccess($id, 'admin')) {
              $auth->revokeAll($id);
              Yii::$app->session->setFlash('success', "Revoke Success.");
        }else{
          Yii::$app->session->setFlash('danger', "Cannot Revoke Admin.");
        }

        return $this->redirect(['index']);
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
