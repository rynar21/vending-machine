<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\StoreSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Stores';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="store-index">

    <!-- 标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title) ?>
        </h1>
    </div>

    <!-- 创建 新商店 -->
    <div class="row">
        <div class="col-sm-12">
            <?= Html::a('Create Store', ['create'], ['class' => 'btn btn-success pull-right']) ?>
        </div>
    </div>

    <br/>

    <!-- 查询功能：启动 _search.php 代码 -->
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <!-- 分隔线 -->
    <hr />

    <!-- 商店列表 -->
    <div class="row">
        <!-- 根据查询返回结果 -->
        <?php if($dataProvider->query->all()):?>
            <!-- $dataProvider 不是为空 -->
            <div class="store_result_list">
                <?php foreach ($dataProvider->query->all() as $store): ?>
                      <div class="col-lg-3">
                        <br/>
                        <a href="<?= Url::base()?>/store/view?id=<?= $store->id ?>">
                           <div class="btn btn-store text-center">
                             <?= $store->name ?>
                           </div>
                        </a>
                      </div>
                <?php endforeach; ?>
            </div>
        <?php else:?>
            <!-- $dataProvider为空 -->
            <h4 class="col-sm-12 text-center">
                NO RESULT FOUND
            </h4>
        <?php endif;?>
    </div>

</div>


<style>
.store-index>hr{
    height: 8px;
    background-image: linear-gradient(90deg,transparent, #5f5d46, transparent);
}
.store_result_list{
    margin-left: 17%;
    width: 90%;
}

.col-lg-3{
    display: inline-block;
    float: none;
}

.btn-store{
    width:200px;

    color:white;
    background-color: #4A4A4A;

	-webkit-transform:scale(0.9);
	-moz-transform:scale(0.9);
	-o-transform:scale(0.9);

	-webkit-transition-duration: 0.5s;
	-moz-transition-duration: 0.5s;
	-o-transition-duration: 0.5s;
}

.btn-store:hover{
     color:#8B8970;
     background-color: #CDCDB4;

	 -webkit-transform:scale(1.0);
     -moz-transform:scale(1.0);
     -o-transform:scale(1.0);

	 -webkit-box-shadow:0px 0px 8px #2B2B2B;
	 -moz-box-shadow:0px 0px 1  8px #2B2B2B;
     -o-box-shadow:0px 0px 8px 	#2B2B2B;

     box-shadow:4px 4px 10px #2B2B2B;
}

.form-group{
     display: inline-block;
     float: none;
}

</style>
