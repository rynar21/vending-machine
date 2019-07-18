<!--
    Done By:    Hung Rui
    Date:       28th June 2019
-->

<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use common\models\Store;

$dataProvider=Store::find(1);

?>

      <div class="row" style="background: white; border: 1px solid black; padding: 35px;">
        <div class="">
            <?php foreach($dataProvider->getModels() as $box): ?>
                <?php //if(($box->store_id) === ($store_model->id)):?>
                    <div class="col-md-3 button">
                      <?php echo "Box: ".$box->code; ?>
                      <br/>
                        <?php
                        // if($box->status !== 2)
                        // {
                        //     foreach($item_model->query->all() as $item)
                        //     {
                        //       if(!empty($item->id))
                        //       {
                        //         // if($box->id === $item->box_id)
                        //         //{
                        //           echo ($item->name);
                        //         //}
                        //       }
                        //     }
                        // }
                        // else
                        // {
                        //   echo "Out of Stock";
                        // }?>
                    </div>
                <?php //endif ?>
            <?php endforeach ?>
          </div>
      </div>
