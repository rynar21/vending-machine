<?php

use yii\db\Migration;

/**
 * Class m190815_093751_init_rbac
 */
class m190815_093751_init_rbac extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $auth = Yii::$app->authManager;

        // add "createPost" permission
        $create = $auth->createPermission('ac_create');
        $auth->add($create);

        // add "createPost" permission
        $read = $auth->createPermission('ac_read');
        $auth->add($read);

        // add "updatePost" permission
        $update = $auth->createPermission('ac_update');
        $auth->add($update);

        // add "deletePost" permission
        $delete = $auth->createPermission('ac_delete');
        $auth->add($delete);

        $sup = $auth->createPermission('ac_sup');
        $auth->add($sup);

        // add "author" role and give this role the "createPost" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $read);

        $staff = $auth->createRole('staff');
        $auth->add($staff);
        $auth->addChild($staff, $create);
        $auth->addChild($staff, $update);
        $auth->addChild($staff, $user);

        $supervisor = $auth->createRole('supervisor');
        $auth->add($supervisor);
        $auth->addChild($staff, $sup);
        $auth->addChild($supervisor, $staff);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($supervisor, $delete);
        $auth->addChild($admin, $supervisor);


        // Assign roles to users. 1 and 2 are IDs returned by IdentityInterface::getId()
        // usually implemented in your User model.
        // $auth->assign($user, 4);
        // $auth->assign($staff, 3);
        // $auth->assign($supervisor, 2);
        // $auth->assign($admin, 1);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $auth = Yii::$app->authManager;

        $auth->removeAll();
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190815_093751_init_rbac cannot be reverted.\n";

        return false;
    }
    */
}
