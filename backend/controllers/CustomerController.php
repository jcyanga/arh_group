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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchCustomer')['fullname'])) {
                $getCustomer = $searchModel->searchCustomerFullname(Yii::$app->request->get('SearchCustomer')['fullname']);

        }else {
                $getCustomer = Customer::find()->all();
        }
        
        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'dataProvider' => $dataProvider, 
                    'getCustomer' => $getCustomer, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
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
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $getCustomer = Customer::find()->all();
        
        if ($model->load(Yii::$app->request->post())) {
            $result = $searchModel->getNameAndEmail(Yii::$app->request->post('Customer') ['fullname'], Yii::$app->request->post('Customer') ['email']);

            if( $result == 1 ) {        
                return $this->render('create', [
                                'model' => $model, 
                                'getCustomer' => $getCustomer, 
                                'errTypeHeader' => 'Warning!', 
                                'errType' => 'alert alert-warning', 
                                'msg' => 'You already enter an existing customer account, Please! Change customer fullname or e-mail.'
                            ]);
            }
            
                if ( !empty( $model->password ) ) {
                    $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                    $model->generateAuthKey();
                    $model->role = 10;
                    $model->deleted = 1;
                }

                $model->member_expiry = date('Y-m-d', strtotime(Yii::$app->request->post('Customer')['member_expiry']));
            
            if( $model->save() ) {

                $emailFrom = 'no-reply@firstcom.com.sg';
                $emailTo = 'jcyanga28@yahoo.com';

                Yii::$app->mailer->compose("layouts/customer_password",[
                            'model' => $model,
                            'fullname' => Yii::$app->request->post('Customer')['fullname'],
                        ])
                   ->setFrom($emailFrom)
                   ->setTo($emailTo)
                   ->setSubject('Arh Group - Customer Membership Confirmation.')
                   ->send();

                return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getCustomer' => $getCustomer,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully added in the database.'
                        ]);

            }else {

                return $this->render('create', [
                                'model' => $model, 
                                'getCustomer' => $getCustomer, 
                                'errTypeHeader' => 'Error!', 
                                'errType' => 'alert alert-error', 
                                'msg' => 'You have an error Check All the required fields.'
                            ]);
            }

        } else {

            return $this->render('create', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
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
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ( $model->load(Yii::$app->request->post()) ) {
            $model->member_expiry = date('Y-m-d', strtotime(Yii::$app->request->post('Customer')['member_expiry']));

            if($model->save()) {

                $getCustomer = Customer::find()->all();

                return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getCustomer' => $getCustomer,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully updated in the database.'
                        ]);

            }

        } else {
            return $this->render('update', [
                                'model' => $model, 
                                'errTypeHeader' => '', 
                                'errType' => '', 
                                'msg' => ''
                            ]);
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
        $searchModel = new SearchCustomer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();
        $getCustomer = Customer::find()->all();

        return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'getCustomer' => $getCustomer,
                        'dataProvider' => $dataProvider, 
                        'errTypeHeader' => 'Success!', 
                        'errType' => 'alert alert-success', 
                        'msg' => 'Your record was successfully deleted in the database.'
                    ]);
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

    public function actionPointsRedemptionHistory($id)
    {   
        $searchModel = new SearchCustomer();

        $getPoints = Customer::findOne($id);
        $customerPoints = $getPoints->points;
        
        $getRedeemPoints = $searchModel->getRedeemPoints($id);
        
        return $this->render('_points-redeem', [
                                'model' => $this->findModel($id),
                                'customerPoints' => $customerPoints,
                                'getRedeemPoints' => $getRedeemPoints,
                            ]);
    }

    public function actionExportExcel() 
    {
        $result = Customer::find()->all();
        
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
             ->setCellValue('A1', 'Fullname')
             ->setCellValue('B1', 'Address')
             ->setCellValue('C1', 'Email Address')
             ->setCellValue('D1', 'Hand-Phone Number')
             ->setCellValue('E1', 'Office Number')
             ->setCellValue('F1', 'Race')
             ->setCellValue('G1', 'Car Model')
             ->setCellValue('H1', 'Car Plate')
             ->setCellValue('I1', 'Member Expiry')
             ->setCellValue('J1', 'Status');
             
             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('D1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('E1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('F1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('G1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('H1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('I1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('J1')->applyFromArray($styleHeadingArray);

         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $expiryDate = date('m-d-Y', strtotime($result_row['member_expiry']) );    
                    $status = ( $result_row['status'] == 1 ) ? 'Active' : 'Inactive';

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['fullname']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['hanphone_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['office_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['race']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['model']);
                    $objPHPExcel->getActiveSheet()->setCellValue('H'.$row,$result_row['carplate']);
                    $objPHPExcel->getActiveSheet()->setCellValue('I'.$row,$expiryDate);
                    $objPHPExcel->getActiveSheet()->setCellValue('J'.$row,$status);
                    
                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "CustomerList-".date("d-m-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $result = Customer::find()->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream();
    }

}
