<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'User';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="User-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'username',
            'email',
            ['class' => 'yii\grid\ActionColumn', 'template' => 'Staff | Supervisor | Revoke',
            'buttons' => ['Staff' => Assign($role => 'staff', $this->id),
                          'Supervisor' => Assign($role => 'supervisor', $this->id),
                          'Revoke' => Revoke($role, $this->id)],
          ],
          ],
    ]); ?>


</div>
