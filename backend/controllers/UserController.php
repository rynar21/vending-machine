<?php
namespace backend\controllers;

use Yii;
use common\models\User;
use backend\models\UserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\CreateUser;
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
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['ac_delete'],
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ac_update'],
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

        $model = new CreateUser();
        if ($model->load(Yii::$app->request->post()) && $model->createUser()) {
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
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    //To assign user Role
    public function actionAssign($role, $id)
    {
          $auth = Yii::$app->authManager;
          if (!$auth->checkAccess($id,'admin')) {
              $auth->revokeAll($id);
              $auth_role = $auth->getRole($role);
              $auth->assign($auth_role, $id);
              Yii::$app->session->setFlash('success', "Edit Success.");
            }
            else
            {
              Yii::$app->session->setFlash('danger', "Cannot Edit Admin!");
              // throw new MethodNotAllowedHttpException('Cannot edit admin.');
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
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    public function actionTest(){
        $auth = Yii::$app->authManager;
        return $auth->removeAll();
    }
}


//############actionCreate_OLD##############
// $model = new User();
// if ($model->load(Yii::$app->request->post()) ) {
//     if ($model->save()) {
//         return $this->redirect(['view', 'id' => $model->id]);
//     }

//     return $this->redirect('create', [
//         'model' => $model,
//     ]);
// }

    // $request = Yii::$app->request;
    //
    // if ($data = $request->post('user')) {
    //     $model = new user();
    //     $model->user_name = $data['user_name'];
    //     $model->user_id = $data['user_id'];
    //     if ($model->validate()) {
    //         if ($model->save()) {
    //             return $this->redirect(['view', 'id' => $model->id]);
    //         }
    //     }
    // }



//############## Old permission ############
    // [
    //     'actions' => ['update'],
    //     'allow' => true,
    //     'roles' => ['admin'],
    // ],
    // [
    //     'actions' => ['create'],
    //     'allow' => true,
    //     'roles' => ['ac_create'],
    // ],
    // [
    //     'actions' => ['delete'],
    //     'allow' => true,
    //     'roles' => ['admin'],
    // ],
