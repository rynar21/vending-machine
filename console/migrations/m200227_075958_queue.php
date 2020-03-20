<?php

use yii\db\Migration;

use common\models\User;

/**
 * Class m200227_075958_queue
 */
class m200227_075958_queue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
            $this->createTable('queue',[
           'id' => $this->primaryKey(),
           'store_id'=> $this->integer()->notNull(),
           'action' => $this->string(),
           'priority' => $this->string(),
           'status' => $this->smallInteger()->notNull()->defaultValue(0),
           'created_at' => $this->integer()->notNull(),
           'updated_at' => $this->integer()->notNull(),
       ]);
       $this->first_user();

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('queue');
    }

    public function first_user()
    {
        $model = new User();
        $model->email = 'forgetof@gmail.com';
        $model->username = 'forgetof';
        $model->password_hash = Yii::$app->security->generatePasswordHash('123456');
        $model->auth_key = Yii::$app->security->generateRandomString();
        $model->status = User::STATUS_ACTIVE;
        $model->save();
        $auth = Yii::$app->authManager;
        $auth->revokeAll(1);
        $auth_role = $auth->getRole('admin');
        $auth->assign($auth_role, 1);
    }
    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200227_075958_queue cannot be reverted.\n";

        return false;
    }
    */
}
