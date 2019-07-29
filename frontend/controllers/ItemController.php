<?php
namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Box;
use common\models\Item;
use common\models\SaleRecord;
use backend\models\StoreSearch;
use backend\models\BoxSearch;
use backend\models\ItemSearch;
use backend\models\SaleRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\data\BaseDataProvider;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
    * 主页： 展示所有收购产品
    */
    public function actionHome($id)
    {
        $item_searchModel = new ItemSearch();
        $item_dataProvider = $item_searchModel->searchAvailableItem(Yii::$app->request->queryParams, $id);

         return $this->render('home', [
            'store_model' => $this->findStoreModel($id),
             'id' => $id,
             'item_searchModel' => $item_searchModel,
             'item_dataProvider' => $item_dataProvider,
         ]);
    }

    // 目前没有用到
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $item_store = new StoreSearch();
        $store = $item_store->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'item_store'=> $item_store,
            'item' => $store,
        ]);
    }

    // 购买产品页面
    public function actionPayding($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        
        $record_model = new SaleRecord();
            // $item = Item::findOne($id);
            // $model = new SaleRecord();
            // $model->item_id= $id;
            // $model->box_id= $id;
            // $model->trans_id= $id;
            // $model->save();
        return $this->render('payding', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => Item::findOne($id),
            'model2' => $this->findSaleRecordModel($id),
        ]);
    }

    //购买结果页面
    public function actionRecord($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Item();
        $model2 = new SaleRecord();
        $model3 = new Store();
        $store_model1 = new ActiveDataProvider(['query'=> Box::find(),]);
        return $this->render('record', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findItemModel($id),
            'model2' => $this->findSaleRecordModel($id),
            //'model3'=> $this->findModel3($id),
            'store_model1' => $store_model1,
        ]);
    }

    // 产品信息 （购买前）
    public function actionIphone($id)
    {
        return $this->render('iphone', [
            'model' => Item::findOne($id),
        ]);
    }

    // 购买失败 -》 返回主页
    public function actionCannot($id)
    {
        $box_model = new BoxSearch();
        $box_data = $box_model->search(Yii::$app->request->queryParams);

        $item_model = new ItemSearch();
        $item_data = $item_model->search(Yii::$app->request->queryParams);

        $item = new ActiveDataProvider([
            'query' => Item::find(),
        ]);
        $box = new ActiveDataProvider([
            'query' => Box::find(),
        ]);
        $store = new ActiveDataProvider([
            'query' => Store::find(),
        ]);

        $item_searchModel = new ItemSearch();
        $item_dataProvider = $item_searchModel->searchAvailableItem(Yii::$app->request->queryParams, $id);
        foreach($item->query->all() as $item)
        {
            if($item->id == $id)
            {
                foreach($box->query->all() as $box)
                {
                    if ($box->id == $item->box_id)
                    {
                        return $this->render('home', [
                            'id' => $box->store_id,
                            'store_model'=> $this->findStoreModel($box->store_id),
                            'item_searchModel' => $item_searchModel,
                            'item_dataProvider' => $item_dataProvider,
                        ]);
                    }
                }
            }
        }
    }

    // 接受 IoT 返回的状态来判断
    public function actionOk($id)
    {
        $item = Item::findOne($id);
        if ($item)
        {
            if ($record = SaleRecord::find()->where(['item_id' =>$item->id, 'status' => [SaleRecord::STATUS_PENDING, SaleRecord::STATUS_SUCCESS]])->all())
            {
                // echo "this item cannot be purchase, either is under purchase, or has been purchased";
                $item_model = new Item();
                return $this->render('cannot', [ 'model' => $item_model, ]);
            }

            if ($record = SaleRecord::find()->where(['item_id' =>$item->id, 'status' =>SaleRecord::STATUS_FAILED])->all())
            {
                //SaleRecord::updateAll(['status' => SaleRecord::STATUS_SUCCESS], ['item_id' =>$id]);
                return $this->redirect(['payding', 'id' => $id]);
            }
            else
            {
                $record = new SaleRecord();
                $record->item_id= $id;
                $record->store_id= $item->store_id;
                $record->box_id= $item->box_id;
                $record->trans_id= $id;
                $record->status=9;
                $record->save();
                return $this->redirect(['payding', 'id' => $id]);
            }
        }
    }

///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    /* Model 查询
        1. findStoreModel 查询商店数据表
        2. findBoxModel 查询盒子数据表
        3. findItemModel 查询产品数据表
        4. findSaleRecordModel 查询交易数据表
    */
    protected function findStoreModel($id)
    {
        if (($store_model = Store::findOne($id)) !== null)
        {
            return $store_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findBoxModel($id)
    {
        if (($box_model = Box::findOne($id)) !== null)
        {
            return $box_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findItemModel($id)
    {
        if (($item_model = Item::findOne($id)) !== null)
        {
            return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findSaleRecordModel($id)
    {
        if (($record_model = SaleRecord::findOne(['item_id' => $id])) !== null)
        {
            return $record_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    // 查询交易状态
    public function actionTransactionSuccess($id)
    {
        $model = Transaction::findOne($id);
        $model->success();
    }

    public function actionTransactionFailed($id)
    {
        $model = Transaction::findOne($id);
        $model->failed();
    }

    public function actionTransactionPending($id)
    {
        $model = Transaction::findOne($id);
        $model->pending();
    }
}
