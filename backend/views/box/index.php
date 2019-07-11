<!--
    Done By:    Hung Rui
    Date:       28th June 2019
-->

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = 'Boxes';
$this->params['breadcrumbs'][] = $this->title;
?>

<style>
.box-home.container{
  width: 100%;
}


.button {
  margin:10px;
  text-align: center;
  cursor: pointer;
  outline: none;
  color: black;
  background-color: #00FFBA;
  box-shadow: 0 9px #999;
}

.button:hover {
  background-color: #3e8e41;
  color:white;
}

.button:active {
  background-color: #3e8e41;
  box-shadow: 0 5px #666;
  transform: translateY(4px);
}
</style>

<div class="box-home container">
      <!-- 展示店名 -->
      <div class="row">
        <h2 class="col-lg-12 col-md-12"><?= $store_model->name ?></h2>
      </div>

      <!-- 店的盒子 数量 -->
      <div class="row">
        <div class="col-lg-1 col-md-2">
          Number of Box:
        </div>

        <?= Html::a('-', ['index'], ['class' => 'col-lg-1 col-md-1 btn btn-danger']) ?>

        <!-- 盒子总数量 -->
        <div class="col-lg-1 col-md-1 text-center">
            <?php $i = 0; ?>
            <?php foreach($dataProvider->getModels() as $box): ?>
                <?php if(($box->store_id) === ($store_model->id)):?>
                  <?php $i++; ?>
                <?php endif ?>
            <?php endforeach?>
            <?= $i ?>
        </div>

        <?= Html::a('+', ['create'], ['class' => 'col-lg-1 col-md-1 btn btn-success']) ?>

        <div class="">
          <?= Html::a('Transaction<br>Record', ['transaction/index'],
          ['class' => 'glyphicon glyphicon-stats col-lg-offset-4 col-lg-2 col-md-offset-4 col-md-2 btn btn-primary pull-right']) ?>
        </div>

        <div class="col-lg-1 col-md-1"></div>
      </div>

      <br/>

      <div class="row">
          <div class="col-md-3"><h3>Current Box(es):</h3></div>
          <div class="col-md-7"></div>
          <a class="col-md-2 btn btn-danger" href="<?=Url::base()?>/item/home">
              Modify Item
          </a>
      </div>


      <div class="row" style="background: white; border: 1px solid black; padding: 35px;">
        <div class="">
            <?php foreach($dataProvider->getModels() as $box): ?>
                <?php if(($box->store_id) === ($store_model->id)):?>
                    <div class="col-md-3 button">
                      <?php echo "Box: ".$box->code; ?>
                      <br/>
                        <?php
                        if($box->status !== 2)
                        {
                            foreach($item_model->query->all() as $item)
                            {
                              if(!empty($item->id))
                              {
                                if($box->box_id === $item->box_id)
                                {
                                  echo ($item->name);
                                }
                              }
                              else
                              {
                                echo "Missing";
                              }
                            }
                        }
                        else
                        {
                          echo "Out of Stock";
                        }?>
                    </div>
                <?php endif ?>
            <?php endforeach ?>
          </div>
      </div>
</div>
