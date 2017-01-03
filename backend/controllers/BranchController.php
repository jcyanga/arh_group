<?php

namespace backend\controllers;

use Yii;
use common\models\Branch;
use common\models\SearchBranch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
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
     * Lists all Branch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( isset(Yii::$app->request->get('SearchBranch')['code'] ) || isset(Yii::$app->request->get('SearchBranch')['name'] ) ) {

                $code = Yii::$app->request->get('SearchBranch')['code'];
                $name = Yii::$app->request->get('SearchBranch')['name'];

                $getBranch = $searchModel->searchBranch($code,$name);
        }elseif ( Yii::$app->request->get('SearchBranch')['code'] == "" || Yii::$app->request->get('SearchBranch')['name'] == "" ) {
                $getBranch = Branch::find()->all();
        }else {
                $getBranch = Branch::find()->all();
        }

        return $this->render('index', ['searchModel' => $searchModel, 'getBranch' => $getBranch, 'dataProvider' => $dataProvider, 'errTypeHeader' => '', 'errType' => '', 'msg' => ''
        ]);
    }

    /**
     * Displays a single Branch model.
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
     * Creates a new Branch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Branch();

        if ($model->load(Yii::$app->request->post())) {

            $code = Yii::$app->request->post('Branch') ['code'];
            $name = Yii::$app->request->post('Branch') ['name'];

            $result = $model->getBranch($code,$name);

            if( $result == 1 ) {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Warning!', 'errType' => 'alert-warning', 'msg' => 'You already enter an existing account Please! Change the branch code or branch name.']);
            }

            if($model->save()) {
                $searchModel = new SearchBranch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

                $getBranch = Branch::find()->all();

                return $this->render('index', ['searchModel' => $searchModel, 'getBranch' => $getBranch,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully added in the database.']);

            }else {
                return $this->render('create', ['model' => $model, 'errTypeHeader' => 'Error!', 'errType' => 'alert-error', 'msg' => 'You have an error Check All the required fields.']);
            }

        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Updates an existing Branch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
            $searchModel = new SearchBranch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            
            $getBranch = Branch::find()->all();

            return $this->render('index', ['searchModel' => $searchModel, 'getBranch' => $getBranch,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully updated in the database.']);
        } else {
            return $this->render('create', ['model' => $model, 'errTypeHeader' => '', 'errType' => '', 'msg' => '']);
        }
    }

    /**
     * Deletes an existing Branch model.
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
        $searchModel = new SearchBranch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();

        $getBranch = Branch::find()->all();

        return $this->render('index', ['searchModel' => $searchModel, 'getBranch' => $getBranch,
                    'dataProvider' => $dataProvider, 'errTypeHeader' => 'Success!', 'errType' => 'alert-success', 'msg' => 'Your record was successfully deleted in the database.']);
    }

    /**
     * Finds the Branch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() {

        // $model = new Role();

        $result = Branch::find()->all();

        $objPHPExcel = new \PHPExcel();
                 
        $sheet=0;
          
        $objPHPExcel->setActiveSheetIndex($sheet);
        
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
                
            $objPHPExcel->getActiveSheet()->setTitle('xxx')                     
             ->setCellValue('A1', 'Id')
             ->setCellValue('B1', 'Branch Code')
             ->setCellValue('C1', 'Branch Name')
             ->setCellValue('D1', 'Address')
             ->setCellValue('E1', 'Contact Number')
             ->setCellValue('F1', 'Date Created')
             ->setCellValue('G1', 'Status');
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    $dateCreated = date('m-d-Y', strtotime($result_row['created_at']) );    
                    $status = ( $result_row['status'] == 1 ) ? 'Active' : 'Inactive';            
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['code']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$result_row['name']);
                    $objPHPExcel->getActiveSheet()->setCellValue('D'.$row,$result_row['address']);
                    $objPHPExcel->getActiveSheet()->setCellValue('E'.$row,$result_row['contact_no']);
                    $objPHPExcel->getActiveSheet()->setCellValue('F'.$row,$dateCreated);
                    $objPHPExcel->getActiveSheet()->setCellValue('G'.$row,$status);
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

        $result = Branch::find()->all();
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
