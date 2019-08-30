<?php
namespace backend\controllers;

use Yii;
use common\models\Item;
use common\models\Box;
use common\models\Product;
use backend\models\ItemSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

// ItemController implements the CRUD actions for Item model.
class ItemController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view'],
                        'allow' => false,
                    ],
                    // [
                    //     'actions' => ['index', 'view'],
                    //     'allow' => Yii::$app->user->can('supervisor'),
                    // ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ac_item_update'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['ac_item_create'],
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'roles' => ['ac_delete'],
                    ],

                    [
                        'actions' => ['void'],
                        'allow' => true,
                        'roles' => ['ac_delete'],
                    ],


                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    // 显示所有Item 数据
    public function actionIndex()
    {
        // 获取 ItemSearch 数据表
        $searchModel = new ItemSearch();
        // 使用输入字段 进行搜索功能
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // 当前 显示 index 页面 及 带入相关数据
        return $this->render('index', [
            'searchModel' => $searchModel,      // ItemSearch Model
            'dataProvider' => $dataProvider,    // 搜索Item数据
        ]);
    }

    // 显示 当前Item产品数据 详情
    public function actionView($id)
    {
        // 当前 显示 view页面 及 带入相关数据
        return $this->render('view', [
            'model' => $this->findModel($id),   // 使用 $id 搜索当前Item数据
        ]);
    }

    /**
     * 创建 新 Item 产品数据
     * 如果创建成功， 返回 store/view 页面
     * @param integer $id -> Box ID
     * @return mixed
     */
    public function actionCreate($id)
    {
        // 创建 新 Item 数据
        $model = new Item();
        $model->box_id = $id;   // 保存 $id为 Box Id
        $model->store_id = $model->box->store_id; // Item Model里， 运行 Box数据表查询 及 获取当中的 store_id

        // 获取传送的数据 (点击 Save 按钮)
        if ($model->load(Yii::$app->request->post()))
        {
            // 如果没有输入价格
            //print_r($model->sku);
            $getsku=Product::find()->where(['sku' =>$model->sku])->one();

            if($getsku)
            {
                $model->product_id=$getsku->id;
                if ($model->price <= 0)
                {
                    // Item价格 默认为相关Product的价格
                    $model->price = $model->product->price;
                }

                // 保存 数据 进入Item表单里
                if($model->save())
                {
                    // 返回 store/view页面 当保存成功
                    return $this->redirect(['store/view', 'id' => $model->store_id]);
                }
            }
            if (empty($getsku)) {
                Yii::$app->session->setFlash('error', 'Non exist item.');
            }


            // print_r($model->product_id);
            // die();

        }

        // 查询当前店 所有未成功卖出的产品
        $dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($model->box->store_id)]),
        ]);

        // 当前 显示 create 页面 及 带入相关数据
        return $this->render('create', [
            'model' => $model, // 新 Item 数据
            'dataProvider' => $dataProvider, //当前店 所有未成功卖出的产品 数据
        ]);
    }

    /**
     * 更新当前 Item 产品数据
     * 如果更新成功，返回 store/view 页面
     * @param integer $id -> Item ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        // 使用 $id 搜索当前Item数据
        $model = $this->findModel($id);

        // 获取传送的数据 (点击 Save 按钮)
        if ($model->load(Yii::$app->request->post()))
        {
            // 如果没有输入价格
            if ($model->price <= 0)
            {
                // Item价格 默认为相关Product的价格
                $model->price = $model->product->price;
            }
            // 保存 数据 进入Item表单里
            if($model->save())
            {
                // 返回 store/view页面 当保存成功
                return $this->redirect(['store/view', 'id' => $model->store_id]);
            }
        }

        // 查询当前店 所有未成功卖出的产品
        $dataProvider = new ActiveDataProvider([
            'query'=> Item::find()
            ->where(['status'=> [Item::STATUS_AVAILABLE, Item::STATUS_LOCKED],'store_id'=> ($model->box->store_id)]),
        ]);

        // 当前 显示 update 页面 及 带入相关数据
        return $this->render('update', [
            'model' => $model,  //目前 Item ID 的数据
            'dataProvider' => $dataProvider, //当前店 所有未成功卖出的产品 数据
        ]);
    }

    // 废除产品：操作员强行下架产品
    public function actionVoid($id)
    {
        // 使用 $id 搜索当前Item产品 数据
        $model = $this->findModel($id);
        // 更改和保存当前Item的状态
        $model->status = Item::STATUS_VOID;
        $model->save();

        // 搜索 当前Item产品的 Box盒子数据
        $box_model = $model->box;
        // 更改和保存当前 Box盒子的状态
        $box_model->status = Box::BOX_STATUS_NOT_AVAILABLE;
        $box_model->save();

        // 判断是否 成功保存 Item 和 Box 最新的状态
        if($model->save() && $box_model->save())
        {
            // 如果保存成功， 返回 store/view页面
            return $this->redirect(['store/view', 'id' => $model->store_id]);
        }
        else
        {
            // 当保存失败，提示错误
            Yii::$app->session->setFlash('error', 'Error in removing item.');
        }
    }

    // 删除当前的Item
    public function actionDelete($id)
    {
        // 使用 $id 搜索当前Item产品 数据
        $model = $this->findModel($id);
        // 判断是否删除 当前Item产品 数据
        if($model->delete())
        {
            // 如果删除成功， 返回 index页面
            return $this->redirect(['index']);
        }

    }

    // 寻找当前 Item 产品 数据
    protected function findModel($id)
    {
        // 判断是否 成功获取当前Item产品 数据
        if (($model = Item::findOne($id)) !== null)
        {
            // 返回 当前Item产品 数据
            return $model;
        }
        //报错：当前页面不存在
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    // public function testmyfunction()
    // {
    //     $this->dosomething(1, 'test', '/hello.jpg', 'hi');
    //
    //     $this->dosomething(1, null, null, 'hello');
    //
    //     $this->anotherthing([
    //         'id' => 1,
    //         'path' => [
    //             'location' => '/hello/test',
    //             'file' => 'abc.jpg',
    //             'extensions' => 'jpeg',
    //         ]
    //     ]);
    //
    // }
    //
    //
    // public function dosomething($id,  $path, $name)
    // {
    //     if ($name == null) {
    //         $name = '/hello.jpg';
    //     }
    //     // execute something with parameter
    // }
    //
    // use yii\helpers\ArrayHelper;
    //
    // public function anotherthing($config)
    // {
    //     $id = ArrayHelper::getValue($config, 'id', 1);
    //
    //     $path = $config['path'];
    //
    //     // execute something with parameter
    // }

}
