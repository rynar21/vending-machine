<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\common\models\PmsLog */

$this->title = 'User Log';
?>
<div class="log-view">
    <div class="card">
        <h1><?= Html::encode($this->title) ?></h1>

        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'id',
                [
                    'attribute' => 'user.username',
                    'label'=> 'Operator',
                ],
                'type',
                'action',
                'data_json:ntext',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]) ?>

        <div class="row">
            <h1 class="col-sm-12">
                <?= Html::a('Back', ['log/index',], ['class' => 'btn btn-primary']) ?>
            </h1>
        </div>
    </div>
</div>
