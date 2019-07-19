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
    /**
     * {@inheritdoc}
     */
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
     * @return mixed
     */
    public function actionHome($id)
    {
      $item_model = new ItemSearch();
      $item_data = $item_model->search(Yii::$app->request->queryParams);

      $store_data = new ActiveDataProvider(['query'=> Store::find(),]);
      $box_data = new ActiveDataProvider(['query'=> Box::find(),]);
      $record_data = new ActiveDataProvider(['query'=> SaleRecord::find(),]);

      return $this->render('home', [
          'store_model' => $this->findModelStore($id),
          'item_model' => $item_model,
          'item_data' => $item_data,
          'store_data' => $store_data,
          'box_data' => $box_data,
          'record_data' => $record_data,
          'id' => $id,
      ]);
    }


    public function actionIphone($id)
    {
          $model = new ActiveDataProvider(['query'=> Item::find(),]);
          return $this->render('iphone', [
              'model' => $this->findModel($id),
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
            'model' => $this->findModel($id),
            'model2' => $this->findModel2($id),

        ]);
    }

    public function actionRecord($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Item();
        $model2 = $this->findModel2($id);
        $model3 = new Box();
        return $this->render('record', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findModel($id),
            'model2' => $model2,
            'model3'=> $this->findModel3($id),
        ]);
    }

    /* Find Model Item*/
    protected function findModel($id)
    {
        if (($item_model = Item::findOne($id)) !== null)
        {
            return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model SaleRecord */
    protected function findModel2($id)
    {
        if (($model = SaleRecord::findOne($id)) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model Box*/
    protected function findModel3($id)
    {
        if (($model3 = Box::findOne($id)) !== null)
        {
            return $model3;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /* Find Model Store */
    protected function findModelStore($id)
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
