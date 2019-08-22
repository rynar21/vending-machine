<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Box */

$this->title = 'Create Box';
$this->params['breadcrumbs'][] = ['label' => 'Boxes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="box-create">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?php echo $this->render('_form_create', [
        'model' => $model,
    ]) ?>

</div>
