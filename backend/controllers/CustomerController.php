<?php

namespace backend\controllers;

use Yii;
use common\models\Customer;
use common\models\SearchCustomer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * CustomerController implements the CRUD actions for Customer model.
 */
class CustomerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Customer'])->andWhere(['role_id' => $uRId ] )->all();
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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( isset(Yii::$app->request->get('SearchCustomer')['fullname'] ) ) {

                $fullname = Yii::$app->request->get('SearchCustomer')['fullname'];
                $getCustomer = $searchModel->searchCustomer($fullname);

        }elseif ( Yii::$app->request->get('SearchCustomer')['fullname'] == "" ) {
                $getCustomer = Customer::find()->all();

        }else {
                $getCustomer = Customer::find()->all();
        }
        
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getCustomer' => $getCustomer, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Customer model.
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
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Customer();

        if ($model->load(Yii::$app->request->post())) {

            $fullname = Yii::$app->request->post('Customer') ['fullname'];
            $email = Yii::$app->request->post('Customer') ['email'];

            $result = $model->getNameAndEmail($fullname, $email);

            if( $result == 1 ) {
                
                return $this->render('create', ['model' => $model, 'getCustomer' => $getCustomer, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change customer fullname or e-mail.']);
            }
        
            if($model->save()) {
                $searchModel = new SearchCustomer();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getCustomer = Customer::find()->all();

                return $this->render('index', ['searchModel' => $searchModel, 'getCustomer' => $getCustomer,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {

                return $this->render('create', ['model' => $model, 'getCustomer' => $getCustomer, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {

            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchCustomer();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            $getCustomer = Customer::find()->all();

            return $this->render('index', ['searchModel' => $searchModel, 'getCustomer' => $getCustomer,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('update', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing Customer model.
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
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        $getCustomer = Customer::find()->all();

        return $this->render('index', ['searchModel' => $searchModel, 'getCustomer' => $getCustomer,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        $model = new Customer();

        $result = $model->getCustomerList();

        $objPHPExcel = new \PHPExcel();
                 
        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Fullname')
             ->setCellValue('B1', 'Address')
             ->setCellValue('C1', 'Email Address')
             ->setCellValue('D1', 'Hand-Phone Number')
             ->setCellValue('E1', 'Office Number')
             ->setCellValue('F1', 'Race')
             ->setCellValue('G1', 'Car Model')
             ->setCellValue('H1', 'Car Plate')
             ->setCellValue('I1', 'Member Expiry');
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['fullname']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['hanphone_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['office_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['race']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['model']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$result_row['member_expiry']);
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

        $model = new Customer();

        $result = $model->getCustomerList();
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
