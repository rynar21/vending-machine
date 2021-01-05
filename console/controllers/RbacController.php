<?php
namespace console\controllers;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;

use yii\helpers\VarDumper;

use common\models\User;
use console\models\SignupForm;

class RbacController extends Controller
{
    public function actionInit()
    {
        $this->down();

        $auth = Yii::$app->authManager;

        $allowModifyEntry = $auth->createPermission('allowAddProduct');
        $allowModifyEntry->description = 'Give permission to access product.';
        $auth->add($allowModifyEntry);

        $allowCash = $auth->createPermission('allowRecord');
        $allowCash->description = 'Give permission to create bill manually';
        $auth->add($allowCash);

        $allowSeasonPass = $auth->createPermission('allowReport');
        $allowSeasonPass->description = 'Give permission to access report.';
        $auth->add($allowSeasonPass);

        $allowAssign = $auth->createPermission('allowAssign');
        $allowAssign->description = 'Give permission to assign role and permission';
        $auth->add($allowAssign);

        $operator = $auth->createRole('operator');
        $auth->add($operator);

        $cashier = $auth->createRole('cashier');
        $auth->add($cashier);

        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $operator);
        $auth->addChild($admin, $allowModifyEntry);
        $auth->addChild($admin, $allowSeasonPass);
        $auth->addChild($admin, $allowCash);
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
