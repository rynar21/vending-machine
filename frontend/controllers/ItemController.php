<?php
namespace frontend\controllers;

use Yii;
use common\models\Store;
use common\models\Box;
use common\models\Item;
use common\models\SaleRecord;
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
     * Lists all Item models.
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


    public function actionIphone($id)
    {
          $model = new ActiveDataProvider(['query'=> Item::find(),]);
          return $this->render('iphone', [
              'model' => $this->findItemModel($id),
          ]);
    }

    public function actionOk($id)
    {
          $model = new ActiveDataProvider(['query'=> SaleRecord::find(),]);
          $model->item_id= $id;
          $model->box_id= $id;
          $model->trans_id= $id;
          $model->save();
          return $this->redirect(['payding', 'id'=>$id]);
    }

    public function actionPayding($id)
    {
        $model = new Item();
        $model2 = new SaleRecord();

        return $this->render('payding', [
            'model' => $this->findItemModel($id),
            'model2' => $this->findSaleRecordModel($id),

        ]);
    }

    public function actionRecord($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Item();
        $model2 = $this->findModel2($id);
        $model2->success();
        $model3 = new Box();
        return $this->render('record', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findItemModel($id),
            'model2' => $model2,
            'model3'=> $this->findBoxModel($id),
        ]);
    }

    /* Find Model Item*/
    protected function findItemModel($id)
    {
        if (($item_model = Item::findOne($id)) !== null)
        {
            return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model SaleRecord */
    protected function findSaleRecordModel($id)
    {
        if (($model = SaleRecord::findOne($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model Box*/
    protected function findBoxModel($id)
    {
        if (($model3 = Box::findOne($id)) !== null)
        {
            return $model3;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model Store */
    protected function findStoreModel($id)
    {
        if (($store_model = Store::findOne($id)) !== null)
        {
            return $store_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


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
