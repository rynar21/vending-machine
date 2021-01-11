<?php

namespace backend\controllers;

use Yii;
use common\models\Log;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use backend\models\LogSearch;

/**
 * LogController implements the CRUD actions for PmsLog model.
 */
class LogController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'actions' => ['index', 'view','csv-export'],
                        'allow' => true,
                        'roles' => ['admin'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PmsLog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PmsLog model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionSearch($start_time, $end_time)
    {
        $start_timestamp    = strtotime($start_time);
        $end_timestamp      = strtotime($end_time);

        $searchModel = new LogSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams,  $start_timestamp, $end_timestamp);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCsvExport()
    {
        $searchModel = new LogSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);
        $data = $dataProvider->query->each();

        if (empty($data)) {
            Yii::$app->session->setFlash('danger', 'system log is not existed');

            return $this->redirect('index');
        }

        $fields = ['type', 'action', 'message', 'time', 'Username'];

        foreach ($data as $data) {
            $json_data = Json::decode($data['data_json']);

            $model[] = [
                $data['type'],
                $data['action'],
                $data['data_json'],
                date('d-M-Y H:i:sa',$data['created_at']),
                $data->user->username
            ];
        }

        Log::push(Yii::$app->user->identity->id,'log ','export');

        $this->export_csv($model,$fields);
    }

    public function export_csv($data, $fields)
    {
        $filename = "cityone_system_log_". date("d/M/Y", time());

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$filename.'.csv"');
        header('Cache-Control: max-age=0');

        $fp = fopen('php://output', 'a');
        $flush_count = 0;
        $flush_limit = 100000;
        $csv_header = [];

        for($i = 0; $i < count($fields); $i++) {
            array_push($csv_header, mb_convert_encoding($fields[$i], 'gb2312','utf-8'));
        }

        fputcsv($fp, $csv_header);
        $all = count($data);

        for ($i = 0; $i < $all; $i++) {
            $flush_count++;

            if ($flush_limit == $flush_count){
                ob_flush();
                flush();
                $flush_count = 0;
            }

            $row = $data[$i];

            for ($k = 0; $k < count($row); $k++) {
                $row[$k] = mb_convert_encoding($row[$k], 'gb2312', 'utf-8');
            }
            fputcsv($fp, $row);
        }
        fclose($fp);

        exit();
    }

    protected function findModel($id)
    {
        if (($model = Log::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
