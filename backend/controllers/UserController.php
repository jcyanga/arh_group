<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use common\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;
/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( isset(Yii::$app->request->get('SearchUser')['fullname'] ) || isset(Yii::$app->request->get('SearchUser')['username'] ) || isset(Yii::$app->request->get('SearchUser')['email'] )) {

                $fullname = Yii::$app->request->get('SearchUser')['fullname'];
                $username = Yii::$app->request->get('SearchUser')['username'];
                $email = Yii::$app->request->get('SearchUser')['email'];

                $getUser = $searchModel->searchUser($fullname,$username,$email);
        }elseif ( Yii::$app->request->get('SearchUser')['fullname'] == "" || Yii::$app->request->get('SearchUser')['username'] == "" || Yii::$app->request->get('SearchUser')['email'] == "" ) {
                $getUser = $searchModel->getUser();

        }else {
                $getUser = $searchModel->getUser();
        }
        
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, 'getUser' => $getUser, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();
        $auth = Yii::$app->authManager;

        if ($model->load(Yii::$app->request->post())) {

            $model->created_by = Yii::$app->user->identity->id;
            $currentDateTime = new \yii\db\Expression('NOW()');
            $model->created_at = $currentDateTime;

            $username = Yii::$app->request->post('User') ['username'];
            $email = Yii::$app->request->post('User') ['email'];

            $result = $model->getUsernameAndEmail($username, $email);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change customer username or email.']);
            }
            
            if ( !empty ( $model->password ) ) {
                $model->password_hash = Yii::$app->security->generatePasswordHash($model->password); 
                $model->generateAuthKey();
                unset($model->password);
            }

            if($model->save()) {

               $userRoleId = $model->role_id;

                if ( $userRoleId == 1) {
                    $userRole = $auth->getRole('developer');
                    $auth->assign($userRole, $model->id);
                }
                if ( $userRoleId == 2) {
                    $userRole = $auth->getRole('admin');
                    $auth->assign($userRole, $model->id);
                }
                if ( $userRoleId == 3) {
                    $userRole = $auth->getRole('staff');
                    $auth->assign($userRole, $model->id);
                }
                if ( $userRoleId == 4) {
                    $userRole = $auth->getRole('customer');
                    $auth->assign($userRole, $model->id);
                }

                $searchModel = new SearchUser();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getUser = $searchModel->getUser();

                return $this->render('index', ['searchModel' => $searchModel,
                    'dataProvider' => $dataProvider, 'getUser' => $getUser, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }
        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchUser();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            $getUser = $searchModel->getUser();

            return $this->render('index', ['searchModel' => $searchModel, 'getUser' => $getUser,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('update', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing User model.
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
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $getUser = $searchModel->getUser();

        $this->findModel($id)->delete();
        return $this->render('index', ['searchModel' => $searchModel, 'getUser' => $getUser,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        // $model = new Role();

        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $result = $searchModel->getUser();

        $objPHPExcel = new \PHPExcel();
                 
        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Id')
             ->setCellValue('B1', 'Role')
             ->setCellValue('C1', 'Fullname')
             ->setCellValue('D1', 'Username')
             ->setCellValue('E1', 'Email')
             ->setCellValue('F1', 'Status')
             ->setCellValue('G1', 'Date Created');
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['role']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['fullname']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['username']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['email']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$result_row['status']);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$result_row['created_at']);
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

        // $result = Modules::find()->all();
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $result = $searchModel->getUser();
        
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
