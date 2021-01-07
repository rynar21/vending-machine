<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;

class RbacController extends Controller
{
    public function actionInit()
    {
        $this->down();

        $auth = Yii::$app->authManager;

        $allowProduct = $auth->createPermission('allowProduct');
        $allowProduct->description = 'Give permission to access product.';
        $auth->add($allowProduct);

        $allowRecord = $auth->createPermission('allowRecord');
        $allowRecord->description = 'Give permission to view record and manual open unopen purchased box';
        $auth->add($allowRecord);

        $allowReport = $auth->createPermission('allowReport');
        $allowReport->description = 'Give permission to access report.';
        $auth->add($allowReport);

        $allowAssign = $auth->createPermission('allowAssign');
        $allowAssign->description = 'Give permission to assign role and permission';
        $auth->add($allowAssign);

        $staff = $auth->createRole('staff');
        $auth->add($staff);

        $supervisor = $auth->createRole('supervisor');
        $auth->add($supervisor);
        $auth->addChild($supervisor, $staff);


        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $supervisor);
        $auth->addChild($admin, $allowProduct);
        $auth->addChild($admin, $allowRecord);
        $auth->addChild($admin, $allowReport);
        $auth->addChild($admin, $allowAssign);
    }

    protected function down()
    {
        $auth = Yii::$app->authManager;
        $auth->removeAll();
    }

    public function actionAssignAdmin($user_id)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole('admin');
        $auth->assign($role, $user_id);
    }

    public function actionAssignUser($user_id, $permission_name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getRole($permission_name);
        $auth->assign($role, $user_id);
    }

    public function actionAssignPermission($user_id, $role_name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getPermission($role_name);
        $auth->assign($role, $user_id);
    }

    public function actionRevokePermission($user_id, $permission_name)
    {
        $auth = Yii::$app->authManager;
        $role = $auth->getPermission($permission_name);
        $auth->revoke($role, $user_id);
    }
}
