<?php

namespace backend\controllers;

use Yii;
use common\models\Supplier;
use common\models\SearchSupplier;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * SupplierController implements the CRUD actions for Supplier model.
 */
class SupplierController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Modules'])->andWhere(['role_id' => $uRId ] )->all();
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
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     // 'only' => ['index', 'create', 'update', 'view', 'delete'],
            //     'rules' => [
                    
            //         [
            //             'actions' => $action['developer'],
            //             'allow' => $allow['developer'],
            //             'roles' => ['developer'],
            //         ],

            //         [
            //             'actions' => $action['admin'],
            //             'allow' => $allow['admin'],
            //             'roles' => ['admin'],
            //         ],

            //         [
            //             'actions' => $action['staff'],
            //             'allow' => $allow['staff'],
            //             'roles' => ['staff'],
            //         ],

            //         [
            //             'actions' => $action['customer'],
            //             'allow' => $allow['customer'],
            //             'roles' => ['customer'],
            //         ]
       
            //     ],
            // ],

            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all Supplier models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( isset(Yii::$app->request->get('SearchSupplier')['supplier_code'] ) || isset(Yii::$app->request->get('SearchSupplier')['supplier_name'] ) ) {

                $supplier_code = Yii::$app->request->get('SearchSupplier')['supplier_code'];
                $supplier_name = Yii::$app->request->get('SearchSupplier')['supplier_name'];

                $getSupplier = $searchModel->searchSupplier($supplier_code,$supplier_name);
        }elseif ( Yii::$app->request->get('SearchSupplier')['supplier_code'] == "" || Yii::$app->request->get('SearchSupplier')['supplier_name'] == "" ) {
                $getSupplier = Supplier::find()->all();
        }else {
                $getSupplier = Supplier::find()->all();
        }

        return $this->render('index', ['searchModel' => $searchModel, 'getSupplier' => $getSupplier, 'dataProvider' => $dataProvider, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Supplier model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Supplier model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Supplier();

        if ($model->load(Yii::$app->request->post())) {

            $supplier_code = Yii::$app->request->post('Supplier') ['supplier_code'];
            $supplier_name = Yii::$app->request->post('Supplier') ['supplier_name'];

            $result = $model->getSuppliers($supplier_code,$supplier_name);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change the supplier name or supplier code.']);
            }

            if($model->save()) {
                $searchModel = new SearchSupplier();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getSupplier = Supplier::find()->all();

                return $this->render('index', ['searchModel' => $searchModel, 'getSupplier' => $getSupplier,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Supplier model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchSupplier();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            $getSupplier = Supplier::find()->all();

            return $this->render('index', ['searchModel' => $searchModel, 'getSupplier' => $getSupplier,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing Supplier model.
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
        $searchModel = new SearchSupplier();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        $getSupplier = Supplier::find()->all();

        return $this->render('index', ['searchModel' => $searchModel, 'getSupplier' => $getSupplier,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the Supplier model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Supplier the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Supplier::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        // $model = new Role();

        $result = Supplier::find()->all();

        $objPHPExcel = new \PHPExcel();
                 
        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Id')
             ->setCellValue('B1', 'Supplier Code')
             ->setCellValue('C1', 'Supplier Name')
             ->setCellValue('D1', 'Address')
             ->setCellValue('E1', 'Contact Number');
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['supplier_code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['supplier_name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['contact_number']);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "CustomerList-".date("d-m-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() {

        // $model = new Role();

        $result = Supplier::find()->all();
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
