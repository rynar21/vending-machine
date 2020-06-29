<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\grid\GridView;
use common\models\User;
use common\models\Store;
use common\models\Item;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use common\models\Box;
use common\models\product;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Store */

?>

<div class="store-view">
    <!-- 显示 店名为标题 -->
    <div class="row">
        <h1 class="col-sm-12">
            <?= Html::encode($this->title);
            //echo $md;
            ?>
    </div>
<?php

    if ($model->status != Store::STATUS_IN_MAINTENANCE)
    {
        echo DetailView::widget([
              'model' => $model,
              'attributes' => [
                    [
                        'attribute'=>'name',
                        'format' => 'raw' ,
                        'visible' => Yii::$app->user->can('staff'),
                        'value' => function ($model)
                        {
                            if ($model->user_id == Yii::$app->user->identity->id) {
                                return $model->name.' <div class="btn-group mr-2 pull-right col-lg-4 " role="group" aria-label="Second group"> '.
                                Html::a('Detailed', ['store/store_detailed', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6 ']).
                                Html::a('Sales', ['site/index', ], ['class' => 'btn btn-sm  btn-primary col-lg-6  ']).' </div>';
                            }
                            if (Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id,'admin')) {
                                return $model->name.' <div class="btn-group mr-2 pull-right col-lg-4 " role="group" aria-label="Second group"> '.
                                Html::a('Detailed', ['store/store_detailed', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6 ']).
                                Html::a('Sales', ['site/index', ], ['class' => 'btn btn-sm  btn-primary col-lg-6  ']).' </div>';
                            }
                        }
                    ],
                  [
                      'attribute'=>'Manager',
                      'format' => 'raw' ,
                      'visible' => Yii::$app->user->can('admin'),
                      'value' => function ($model)
                      {
                        return $model->User_name
                        .' <div class="btn-group mr-2 pull-right col-lg-4 " role="group" aria-label="Second group"> '.
                        Html::a('Add', ['store/add_update', 'id' => $model->id], ['class' => 'btn btn-sm btn-info col-lg-6']).
                        Html::a('Revoke', ['store/manager_revoke', 'id' => $model->id], ['class' => 'btn btn-sm  btn-primary col-lg-6 ',
                        'data' => ['confirm' => 'Are you sure you want to revoke this manager?',],]).' </div>';
                      }
                  ],
                  [
                      'attribute'=>'Profit today',
                      'format' => 'currency' ,
                      'value' => function ($model)
                      {
                        return $model->profit_today;
                      }
                  ],
                  [
                      'attribute'=>'Yesterday earnings',
                      'format' => 'currency' ,
                      'value' => function ($model)
                      {
                        return $model->yesterday_earnings;
                      }
                  ],
                  [
                      'attribute'=>'Statement inquiry',
                      'format' => 'raw' ,
                      'value' => function ($model)
                      {
                        return
                            // '<div class="btn-group mr-2 pull-left col-lg-12 " role="group" aria-label="Second group">
                            // <form method="GET" action='.Url::to(['finance/datecheck_store']).'>
                            //     <input name="date1"  type="date" required min="2000-01-02"  class=" col-sm-3" >
                            //     <div class="col-sm-1 text-center">-</div>
                            //     <input name="date2"  type="date" required min="2000-01-02" class=" col-sm-3" >
                            //     <input name="store_id" value='.$model->id.' type="hidden"  >
                            //     <input type="submit" name="submit" value="Search" class=" btn btn-sm btn-primary col-sm-2 pull-right">
                            // </form>
                            // </div>'
                            '<div class=" row col-lg-12 " >
                                <div class="   ">
                                    <form method="GET" action='. Url::to(['finance/datecheck_store']).'>
                                        <div class=" row col-lg-6 form-group  ">
                                            <label for="disabledTextInput">Start Time</label>
                                            <input  name="date1"  type="date" required min="2000-01-02"  id="disabledTextInput" class="form-control " >
                                        </div>

                                        <div class=" row col-lg-6 form-group ">
                                            <label for="disabledSelect">End Time</label>
                                            <input name="date2"  type="date" required min="2000-01-02" id="disabledSelect" class="form-control">
                                        </div>
                                            <input name="store_id" value='.$model->id.' type="hidden"  >
                                        <div class=" form-group ">
                                        <input type="submit" class="btn btn-primary"  value="Search">
                                        </div>
                                    </form>
                                </div>
                            </div>';
                      } 
                  ],
              ],
          ]);
    }
?>

    <!-- PHP: 展示时间 -->
    <?php //echo Yii::$app->formatter->asDateTime($model->created_at);
        $auth = Yii::$app->authManager;
        if (!($auth->checkAccess(Yii::$app->user->identity->id,'staff'))) {
            $str =' none';
        };
        if ($auth->checkAccess(Yii::$app->user->identity->id,'staff')) {
            $str =' ';
        } ;
        if (!($auth->checkAccess(Yii::$app->user->identity->id,'admin'))) {
            $str_admin =' none';
        };
        if ($auth->checkAccess(Yii::$app->user->identity->id,'admin')) {
            $str_admin =' ';
        } ;
        if ($model->status == Store::STATUS_IN_MAINTENANCE) {
            $strr = true;
        }
        if ($model->status != Store::STATUS_IN_MAINTENANCE) {
            $strr = false;
        }
    ?>

    <!-- 显示商店拥有的盒子 -->
<div class="btn-group" role="group" aria-label="Second group">

    <?= Html::a('Create Box', ['box/create', 'id' => $model->id], ['class' => 'btn btn-sm btn-info','style'=>"display:"."$str"]) ?>
    <?php


    if ($model->status != Store::STATUS_IN_MAINTENANCE) {
        echo Html::a('Restock ', ['store/lockup_box','id' => $model->id ], ['class' => 'btn btn-sm btn-primary','style'=>"display:"."$str"]);
    }
    // Hide for because easy to forget release store.
    // if ($model->status == Store::STATUS_IN_MAINTENANCE)
    // {
    //     echo Html::a('Release ', ['store/open_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-success','style'=>"display:"."$str"]) ;
    // }

     ?>

    <?= Html::a('Open All Boxes', ['box/open_all_box', 'id' => $model->id], ['class' => 'btn btn-sm btn-danger','style'=>"display:"."$str_admin"]) ?>
</div>

    <div class="col-sm-12">
        <div class="row">

                <?= GridView::widget([
                    'tableOptions' => [
                    'class' => 'table   table-bordered  table-hover ',
                    ],
                    'options' => [
                        'class' => 'table-responsive',
                    ],
                    'dataProvider' => $dataProvider,
                    'filterModel' => $boxSearch,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn'],
                        [
                            'label'=>'Action',
                            'format' => 'raw',
                            'visible' => $strr,
                            'value' => function ($model)
                                {
                                    return $model->action;
                                }
                        ],
                        [
                            'attribute'=> 'code',
                            'label'=> 'Box Code',
                            'filterInputOptions' => [
                                'class'  => 'form-control',
                                'placeholder' => 'Search....'
                            ],
                            'format' => 'raw',
                            'headerOptions' =>['class'=>'col-lg-2',],
                            'value' => function ($model)
                                {
                                    return $model->boxcode;
                                }
                        ],
                        [
                            'attribute' => 'name',
                            'label'=> 'Item',
                            'value' => 'product.name',
                            'filterInputOptions' => [
                                'class'  => 'form-control',
                                'placeholder' => 'Search....'
                             ]
                        ],
                        [
                            'attribute' => 'name',
                            'label'=> 'Last Item',
                            'value' => function ($model)
                                {
                                    return Box::last_item($model->store_id,$model->id);
                                }
                        ],
                        [
                            'attribute'=> 'status',
                            'label' =>'Status',
                            'value' => 'statusText',
                            'filter' => Html::activeDropDownList(
                                $boxSearch,
                                'status', [Box::BOX_STATUS_AVAILABLE => 'Available', Box::BOX_STATUS_NOT_AVAILABLE => 'Not Available'],
                                ['class'=>'form-control','prompt' => 'All Status']),
                        ],
                        'item.price:currency',
                        [
                            // 'attribute'=>'Item History',
                            'format' => 'raw' ,
                            'headerOptions' =>['class'=>'col-lg-2',],
                            'visible' => Yii::$app->user->can('staff'),
                            'value' => function ($model)
                                {
                                    return Html::a('Edit Hardware ID', ['/box/update','id' => $model->id]).
                                    ' | '. Html::a('Item History', ['/store/box_item','box_id' => $model->id,'store_id' => $model->store_id]).
                                    ' | '. Html::a('Order History', ['/sale-record/store_onebox_allsalerecord','box_id' => $model->id,'store_id' => $model->store_id]);
                                }
                        ],
                        ],
                    ]); ?>
        </div>

        <div class="row">

            <div class="container-fluid">
                <div class="col-lg-12">
                    <?php
                    if ($model->status == Store::STATUS_IN_MAINTENANCE)
                    {
                        echo Html::a('Confirm', ['store/open_box', 'id' => $model->id], ['class' => 'pull-right col-lg-3  btn btn-lg btn-success ','style'=>"display:"."$str"]) ;
                    }
                    ?>
                </div>
            </div>

        </div>

    </div>

    <div class="container-fluid">



    </div>

</div>
