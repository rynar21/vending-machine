<?php

namespace backend\controllers;

use Yii;
use common\models\Product;
use common\models\Item;
use backend\models\ProductSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\BaseStringHelper;
use yii\data\ActiveDataProvider;


/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view'],
                        'allow' => Yii::$app->user->can('ac_product_read'),
                    ],
                    // [
                    //     'actions' => ['index', 'view'],
                    //     'allow' =>true,
                    // ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'roles' => ['ac_product_update'],
                    ],
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'roles' => ['ac_product_create'],
                    ],

                    [
                        'actions' => ['delete'],
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

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $item_dataProvider =  new ActiveDataProvider([
            'query' => Item::find()->where(['product_id' => $id]),
        ]);

        return $this->render('view', [
            'model' => $model,
            'item_dataProvider' => $item_dataProvider,
        ]);

    }

    /**
     * 创建新产品记录
     * 如果创建呈贡, 返回 View 页面.
     * @return mixed
     */
    public function actionCreate()
    {
        // 加载 Product 产品 数据表
        $model = new Product();
        // ActiveForm 提交后
        if ($model->load(Yii::$app->request->post())&&$model->save())
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * 更新当前的产品
     * 如果更新成功, 返回 View页面.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())&&$model->save())
        {
           return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        // 判断产品是否存在 在于Item表单中
        //如果存在，Product不可被删除
        if($model->items)
        {
            Yii::$app->session->setFlash('error', 'Product cannot be deleted');

            $text_item_available = '';
            $text_item_void = '';
            $text_item_locked = '';
            $text_item_sold = '';
            $text = '';
            $text_string = array();

            foreach ($model->items as $item)
            {
                switch($item->status)
                {
                    case Item::STATUS_AVAILABLE:
                        if($text_item_available !== 'AVAILABLE Item')
                        {
                            $text_item_available = 'AVAILABLE Item';
                            array_push($text_string, 'AVAILABLE Item');
                        }
                    break;

                    case Item::STATUS_VOID:
                        if($text_item_void !== 'VOID Item')
                        {
                            $text_item_void = 'VOID Item';
                            array_push($text_string, 'VOID Item');
                        }
                    break;

                    case Item::STATUS_LOCKED:
                        if($text_item_locked !== 'LOCKED Item')
                        {
                            $text_item_locked = 'LOCKED Item';
                            array_push($text_string, 'LOCKED Item');
                        }
                    break;

                    case Item::STATUS_SOLD:
                        if($text_item_sold !== 'SOLD Item')
                        {
                            $text_item_sold = 'SOLD Item';
                            array_push($text_string, 'SOLD Item');
                        }
                    break;

                    default:
                    break;
                }
            }

            for($x=0; $x < count($text_string)-1; $x++)
            {
                $text = $text.$text_string[$x].', ';
            }

            $text = 'Tips: <br>'.'Contains '.$text.$text_string[count($text_string)-1].'.';

            Yii::$app->session->addFlash('info', $text);
        }
        else
        {
            if($model->delete())
            {
                if ($model->image)
                {
                    if (file_exists(Yii::getAlias('@upload') . '/' . $model->image))
                    {
                        unlink(Yii::getAlias('@upload') . '/' . $model->image);
                    }
                }
            }
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
