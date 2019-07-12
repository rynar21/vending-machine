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
      $box_model = new BoxSearch();
      $box_data = $box_model->search(Yii::$app->request->queryParams);

      $item_model = new ItemSearch();
      $item_data = $item_model->search(Yii::$app->request->queryParams);

      $store_model = new ActiveDataProvider(['query'=> Store::find(),]);

      return $this->render('home', [
          'store_model' => $this->findModelStore($id),
          'item_model' => $item_model,
          'item_data' => $item_data,
          'box_model' => $box_model,
          'box_data' => $box_data,
          'id' => $id,
      ]);
    }

    /**
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $item_store = new StoreSearch();
        $store = $item_store->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'item_store'=>$item_store,
            'item'=>$store,

        ]);
    }
    public function actionPayding($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);
        $model = new Item();
        $model2 = new SaleRecord();


        // $item = Item::findOne($id);
        // $model = new SaleRecord();
        // $model->item_id= $id;
        // $model->box_id= $id;
        // $model->trans_id= $id;
        // $model->save();

        return $this->render('payding', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findModel($id),
            'model2' => $this->findModel2($id),
        ]);

    }

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
            'model' => $this->findModel($id),
            'model2' => $this->findModel2($id),
            //'model3'=> $this->findModel3($id),
            'store_model1' => $store_model1,
        ]);
    }

    // public function actionTest()
    // {
    //     $model = Item::findone(1);
    //     echo "<pre>";
    //     print_r ($model->store);
    // }



    public function actionIphone($id)
    {
        $searchModel = new ItemSearch();
        $item_model = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('iphone', [
            'searchModel' => $searchModel,
            'item_model' => $item_model,
            'model' => $this->findModel($id),
        ]);
    }

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
        foreach($item->query->all() as $item)
        {
            if($item->id == $id){
                foreach($box->query->all() as $box)
                {
                    if ($box->box_id == $item->box_id) {
                        return $this->render('home', [
                            'id' => $box->store_id,
                            'store_model'=> $this->findModelStore($box->store_id),
                            'item_model' => $item_model,
                            'item_data' => $item_data,
                            'box_model' => $box_model,
                            'box_data' => $box_data,
                        ]);
                    }
                }
            }
        }


    }



    public function actionOk($id)
    {

        $item = Item::findOne($id);
        if ($item) {

            if ($record = SaleRecord::find()->where(['item_id' =>$item->id, 'status' => [9, 10]])->all()) {
                // echo "this item cannot be purchase, either is under purchase, or has been purchased";
                $item_model=new Item();
                return $this->render('cannot', [
                    'model' => $item,
                ]);
            }
            if ($record = SaleRecord::find()->where(['item_id' =>$item->id, 'status' =>8 ])->all()) {
                 SaleRecord::updateAll(['status' => 10], ['item_id' =>$id]);
                 return $this->redirect(['payding', 'id' => $id]);
            }
            else {
                $record = new SaleRecord();
                $record->item_id= $id;
                $record->box_id= $id;
                $record->trans_id= $id;
                $record->status=9;
                $record->save();
                return $this->redirect(['payding', 'id' => $id]);
            }
        }
        // echo '<pre>';
        // print_r($model->errors);
    }

    // public function actionUpd()
    // {
    //     $param = Article::findOne(1);
    //
    //     $param->id = 1;
    //     $param->username= '老乡吃不上饭';
    //     $param->save();
    // }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($item_model = Item::findOne($id)) !== null)
        {
            return $item_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel2($id)
    {
        if (($model = SaleRecord::findOne(['item_id' => $id])) !== null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModel3($id)
    {
        if (($model3 = Store::findOne($id)) !== null)
        {
            return $model3;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelStore($id)
    {
        if (($store_model = Store::findOne($id)) !== null)
        {
            return $store_model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    protected function findModelBox($id)
    {
        if (($store_box = Box::findOne($id)) !== null)
        {
            return $model_box;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
