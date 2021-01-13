<?php
namespace backend\controllers;

use Yii;
use backend\models\User;
use backend\models\UserSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\SignUp;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\filters\AccessControl;
use yii\web\MethodNotAllowedHttpException;
use yii\helpers\Url;
use backend\models\ChangePasswordForm;
use common\models\Log;
use yii\web\Controller;
/**
 * userController implements the CRUD actions for user model.
 */
class UserController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'update','reset-password'],
                        'allow' => true,
                        'roles' => ['allowAssign'],
                    ],
                    [
                        'actions' => ['change-password'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
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

    protected function assignPermission($user_id, $role_name)
    {
        if (Yii::$app->user->identity->id != $user_id){
            $auth = Yii::$app->authManager;
            $role = $auth->getPermission($role_name);

            try {
                $auth->assign($role, $user_id);
            } catch (\Exception $e) {

            }
        }
    }

    protected function revokePermission($user_id, $role_name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getPermission($role_name);
        $auth->revoke($role, $user_id);
    }

    protected function assignRoles($user_id, $role_name)
    {
        if (Yii::$app->user->identity->id != $user_id){
            $this->revokeRoles($user_id);
            $auth = Yii::$app->authManager;
            $role = $auth->getRole($role_name);

            try {
                $auth->assign($role, $user_id);
            } catch (\Exception $e) {
                //
            }
        }
    }

    protected function revokeRoles($user_id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRolesByUser($user_id);

        if ($role) {
            $array = array_keys($role);
            $role = $auth->getRole($array[0]);
            $auth->revoke($role, $user_id);
        }
    }
    /**
     * Displays a single user model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $auth = Yii::$app->authManager;

            if ($model->allow_product) {
                $this->assignPermission($model->id,'allowProduct');
            }else {
                $this->revokePermission($model->id,'allowProduct');
            }

            if ($model->allow_record) {
                $this->assignPermission($model->id,'allowRecord');
            }else {
                $this->revokePermission($model->id,'allowRecord');
            }

            if ($model->allow_report) {
                $this->assignPermission($model->id,'allowReport');
            }else {
                $this->revokePermission($model->id,'allowReport');
            }

            if ($model->allow_assign) {
                $this->assignPermission($model->id,'allowAssign');
            }else {
                $this->revokePermission($model->id,'allowAssign');
            }

            if ($model->roles == 'staff') {
                $this->assignRoles($model->id,'staff');
            }

            if ($model->roles == 'supervisor') {
                $this->assignRoles($model->id,'supervisor');
            }

            if ($model->roles == 'null' ) {
                $this->revokeRoles($model->id);
            }

            $model->save();
            Yii::$app->session->setFlash('success', 'Success.');
        }



        return $this->render('view', [
            'model' => $model,
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
            Log::push(
            Yii::$app->user->identity->id,
            'user',
            'create_user',
            [
                'create_username_is' => Yii::$app->request->getBodyParam('SignUp')['email'],
            ]);

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionChangePassword()
    {
        $model = new ChangePasswordForm();

        if (Yii::$app->user->identity!=null) {

            if( $model->load(Yii::$app->request->post()) && $model->changePassword()) {
                Yii::$app->user->logout();
                Yii::$app->session->setFlash('success', 'password has been updated.');

                return $this->redirect(Url::to(['site/login']));
            }

            return $this->render('changePassword',['model'=>$model]);


        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }

    public function actionResetPassword($id)
    {
        $model = new ChangePasswordForm();

        if (Yii::$app->user->identity!=null) {

            if( $model->load(Yii::$app->request->post()) && $model->resetPassword($id)) {
                Yii::$app->session->setFlash('success', 'password has been updated.');

                return $this->redirect(['view', 'id' => $id]);
            }

            return $this->render('resetPassword',['model'=>$model]);


        }

        throw new NotFoundHttpException('The requested page does not exist.');

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


}
