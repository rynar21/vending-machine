<?php
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

$this->title = 'Items';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="item-home">
    <!-- 显示店名 -->
    <div class="row">
      <h2 class="col-sm-12">
        <?= $store_model->store_name ?>
      </h2>
    </div>

    <hr class="col-sm-12" />
    <!-- 搜索商品名称 -->
    <div class="row">
        <?php $form = ActiveForm::begin(['action' => ['home'], 'method' => 'get',]); ?>
            <div class="col-sm-8 col-xs-8">
              <?= $form->field($item_model, 'name') -> input('name')
                                                    -> textInput(['placeholder' => "Please enter your item name"], ['class' => ''])
                                                    -> label(false) ?>
            </div>
            <div class="col-sm-4 col-xs-4">
              <button type="submit" class="btn btn-primary form-group "> Search </button>
            </div>
        <?php ActiveForm::end(); ?>
    </div>
    <!-- 内容 -->
    <div class="row">
      <p class="col-sm-12"> Select Item to Purchase:</p>
    </div>

    <!-- 选择商品 -->
    <div class="row">
        <?php foreach($box_data->getModels() as $box): ?>
          <?php if ($id == ($box->store_id)):?>
            <?php foreach($item_data->query->all() as $item): ?>
                <?php if($box->box_id == $item->box_id):?>
                  <a class="col-sm-6 col-xs-6" href="iphone?id=<?= $item->id ?>">
                    <div style="height:150px; width: 150px; padding: 10px; box-shadow:2px 0px 10px #CDCDB4; margin: 10px auto;">
                        <p class="text-center" style="color:black; line-height:50vh;"><?= $item->name ?></p>
                    </div>
                  </a>
                <?php endif; ?>
            <?php endforeach; ?>
          <?php endif; ?>
        <?php endforeach; ?>
    </div>

</div>
