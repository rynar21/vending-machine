<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 */
class User extends \common\models\User
{
    public $allow_product;
    public $supervisor;
    public $staff;
    public $allow_view;
    public $allow_record;
    public $allow_report;
    public $allow_admin;
    public $roles;
    public $allow_assign;
    /**
     * {@inheritdoc}
     */
    public function rules()

    {
        return [
            [['allow_product','allow_view','roles','allow_record','allow_report', 'allow_assign', 'status'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'allow_assign' => 'Allow User Management'
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $auth = Yii::$app->authManager;
        $this->allow_product = $auth->checkAccess($this->id, 'allowProduct');
        $this->allow_view = $auth->checkAccess($this->id, 'allowView');
        $this->allow_record = $auth->checkAccess($this->id, 'allowRecord');
        $this->allow_report = $auth->checkAccess($this->id, 'allowReport');
        $this->allow_assign = $auth->checkAccess($this->id, 'allowAssign');

        $this->roles = 'null';
        if ($auth->checkAccess($this->id, 'supervisor')) {
            $this->roles = 'supervisor';
        }

        if ($auth->checkAccess($this->id, 'staff')) {
            $this->roles = 'staff';
        }
    }

}
