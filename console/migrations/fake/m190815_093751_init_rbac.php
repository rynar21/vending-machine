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
        $ac_create = $auth->createPermission('ac_create');
        $auth->add($ac_create);

        // add "createPost" permission
        $ac_read = $auth->createPermission('ac_read');
        $auth->add($ac_read);

        // add "updatePost" permission
        $ac_update = $auth->createPermission('ac_update');
        $auth->add($ac_update);

        // add "deletePost" permission
        $ac_delete = $auth->createPermission('ac_delete');
        $auth->add($ac_delete);

        $ac_user_assign=$auth->createPermission('ac_user_assign');
        $auth->add($ac_user_assign);

        $ac_user_read=$auth->createPermission('ac_user_read');
        $auth->add($ac_user_read);

        $ac_user_revoke=$auth->createPermission('ac_user_revoke');
        $auth->add($ac_user_revoke);

        $ac_item_create=$auth->createPermission('ac_item_create');
        $auth->add($ac_item_create);

        $ac_item_update=$auth->createPermission('ac_item_update');
        $auth->add($ac_item_update);

        $ac_product_create=$auth->createPermission('ac_product_create');
        $auth->add($ac_product_create);

        $ac_product_read=$auth->createPermission('ac_product_read');
        $auth->add($ac_product_read);

        $ac_product_update=$auth->createPermission('ac_product_update');
        $auth->add($ac_product_update);
        // add "author" role and give this role the "createPost" permission
        $user = $auth->createRole('user');
        $auth->add($user);
        $auth->addChild($user, $ac_read);

        $staff = $auth->createRole('staff');
        $auth->add($staff);
        $auth->addChild($staff, $ac_item_create);
        $auth->addChild($staff, $ac_item_update);
        $auth->addChild($staff, $user);

        $supervisor = $auth->createRole('supervisor');
        $auth->add($supervisor);
        $auth->addChild($supervisor, $ac_user_assign);
        $auth->addChild($supervisor, $ac_user_read);
        $auth->addChild($supervisor, $ac_product_create);
        $auth->addChild($supervisor, $ac_product_read);
        $auth->addChild($supervisor, $ac_product_update);
        $auth->addChild($supervisor, $staff);

        // add "admin" role and give this role the "updatePost" permission
        // as well as the permissions of the "author" role
        $admin = $auth->createRole('admin');
        $auth->add($admin);
        $auth->addChild($admin, $ac_create);
        $auth->addChild($admin, $ac_update);
        $auth->addChild($admin, $ac_delete);
        $auth->addChild($admin, $ac_user_revoke);
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

        // $this->dropTable('auth_assignment');
        // $this->dropTable('auth_item');
        // $this->dropTable('auth_item_child');
        // $this->dropTable('auth_rule');


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
