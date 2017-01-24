<?php

namespace backend\controllers;

use Yii;
use common\models\Service;
use common\models\SearchService;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * ServiceController implements the CRUD actions for Service model.
 */
class ServiceController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Service'])->andWhere(['role_id' => $uRId ] )->all();
            $actionArray = [];
            foreach ( $permission as $p )  {
                $actionArray[] = $p->action;
            }

            $allow[$uRName] = false;
            $action[$uRName] = $actionArray;
            if ( ! empty( $action[$uRName] ) ) {
                $allow[$uRName] = true;
            }

        }   
        // print_r($action['developer']); exit;
        return [
            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index', 'create', 'update', 'view', 'delete'],
                'rules' => [
                    
                    [
                        'actions' => $action['developer'],
                        'allow' => $allow['developer'],
                        'roles' => ['developer'],
                    ],

                    [
                        'actions' => $action['admin'],
                        'allow' => $allow['admin'],
                        'roles' => ['admin'],
                    ],

                    [
                        'actions' => $action['staff'],
                        'allow' => $allow['staff'],
                        'roles' => ['staff'],
                    ],

                    [
                        'actions' => $action['customer'],
                        'allow' => $allow['customer'],
                        'roles' => ['customer'],
                    ]
       
                ],
            ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Service models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchService();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( isset(Yii::$app->request->get('SearchService')['service_category_id'] ) ||  isset(Yii::$app->request->get('SearchService')['service_name'] ) ) {

                $service_category_id = Yii::$app->request->get('SearchService')['service_category_id'];
                $service_name = Yii::$app->request->get('SearchService')['service_name'];
                $getService = $searchModel->searchService($service_category_id,$service_name);

        }elseif ( Yii::$app->request->get('searchService')['service_category_id'] == "" &&  Yii::$app->request->get('searchService')['service_name'] == "" ) {
                
                $model = new Service();
                $getService = $model->getServices();

        }else {
                
                $model = new Service();
                $getService = $model->getServices();
        }

        return $this->render('index', ['searchModel' => $searchModel, 'getService' => $getService, 'dataProvider' => $dataProvider, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Service model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {   
        $model = new Service();
        $getServicesById = $model->getServicesById($id);

        return $this->render('view', [
            'model' => $getServicesById,
        ]);
    }

    /**
     * Creates a new Service model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Service();

        if ($model->load(Yii::$app->request->post())) {

            $service_category_id = Yii::$app->request->post('Service') ['service_category_id'];
            $service_name = Yii::$app->request->post('Service') ['service_name'];

            $result = $model->getSameServices($service_category_id,$service_name);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change the service category or service name.']);
            }

            if($model->save()) {
                $searchModel = new SearchService();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getService = $model->getServices();

                return $this->render('index', ['searchModel' => $searchModel, 'getService' => $getService,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Service model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchService();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            $getService = $model->getServices();

            return $this->render('index', ['searchModel' => $searchModel, 'getService' => $getService,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('update', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing Service model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteColumn($id)
    {
        // $this->findModel($id)->delete();
        // $model = $this->findModel($id);
        // $model->deleted = 1;
        // if ( $model->save() ) {
        //     Yii::$app->getSession()->setFlash('success', 'Customer deleted');
        // } else {
        //     Yii::$app->getSession()->setFlash('danger', 'Unable to delete Customer');
        // }
        $model = new Service();

        $searchModel = new SearchService();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        $getService = $model->getServices();

        return $this->render('index', ['searchModel' => $searchModel, 'getService' => $getService,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the Service model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Service the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Service::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        $model = new Service();
        $result = $model->getServices();

        $objPHPExcel = new \PHPExcel();
        $styleHeadingArray = array(
            'font'  => array(
            'bold'  => true,
            'color' => array('rgb' => '000000'),
            'size'  => 11,
            'name'  => 'Calibri'
        ));

        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', '#')
             ->setCellValue('B1', 'Service Category')
             ->setCellValue('C1', 'Service Name')
             ->setCellValue('D1', 'Description')
             ->setCellValue('E1', 'Default Price')
             ->setCellValue('F1', 'Date Created')
             ->setCellValue('G1', 'Status');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $dateCreated = date('m-d-Y', strtotime($result_row['created_at']) );    
                    $status = ( $result_row['status'] == 1 ) ? 'Active' : 'Inactive';    
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['service_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['description']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['default_price']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$dateCreated);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$status);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "ServicesList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() {

        $model = new Service();
        $result = $model->getServices();
        
        $content = $this->renderPartial('_pdf', ['result' => $result]);
        // instantiate and use the dompdf class
        // $dompdf = new Dompdf();

        $dompdf     = new Dompdf();
        //return $pdf->stream();

        $dompdf->loadHtml($content);

        // // (Optional) Setup the paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser
        $dompdf->stream();
          

    }

}
