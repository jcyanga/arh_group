<?php

namespace backend\controllers;

use Yii;
use common\models\TermsAndConditions;
use common\models\SearchTermsAndConditions;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * TermsAndConditionsController implements the CRUD actions for TermsAndConditions model.
 */
class TermsAndConditionsController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
        // $userRole = Role::find()->all();

        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'TermsAndConditions'])->andWhere(['role_id' => $uRId ])->all();
            
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
     * Lists all TermsAndConditions models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchTermsAndConditions();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('searchTermsConditions')['descriptions'])) {
            $getTermsConditions = $searchModel->searchTermsConditions(Yii::$app->request->get('SearchTermsAndConditions')['descriptions']);
        
        }else {
            $getTermsConditions = TermsAndConditions::find()->all();

        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getTermsConditions' => $getTermsConditions, 
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
        ]);
    }

    /**
     * Displays a single TermsAndConditions model.
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
     * Creates a new TermsAndConditions model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TermsAndConditions();
        $searchModel = new SearchTermsAndConditions();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $result = $searchModel->getTermsAndConditions(Yii::$app->request->post('TermsAndConditions') ['descriptions']);

            if( $result == 1 ) {
                return $this->render('create', [
                                'model' => $model, 
                                'errTypeHeader' => 'Warning!', 
                                'errType' => 'alert alert-warning', 
                                'msg' => 'You already enter an existing name, Please! Change the description.']);
            }

            if( $model->save() ) {
                $getTermsConditions = TermsAndConditions::find()->all();

                return $this->render('index', [
                                'searchModel' => $searchModel, 
                                'getTermsConditions' => $getTermsConditions,
                                'dataProvider' => $dataProvider, 
                                'errTypeHeader' => 'Success!', 
                                'errType' => 'alert alert-success', 
                                'msg' => 'Your record was successfully added in the database.'
                            ]);

            } else {
                return $this->render('create', [
                                    'model' => $model, 
                                    'errTypeHeader' => 'Error!', 
                                    'errType' => 'alert alert-error', 
                                    'msg' => 'You have an error, Check All the required fields.'
                                ]);
            }

        } else {
            return $this->render('create', [
                        'model' => $model, 
                        'errTypeHeader' => '', 
                        'errType' => '', 
                        'msg' => '']
                        );
        }
    }

    /**
     * Updates an existing TermsAndConditions model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SearchTermsAndConditions();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
            $getTermsConditions = TermsAndConditions::find()->all();

            return $this->render('index', [
                        'searchModel' => $searchModel, 
                        'getTermsConditions' => $getTermsConditions,
                        'dataProvider' => $dataProvider, 
                        'errTypeHeader' => 'Success!', 
                        'errType' => 'alert alert-success', 
                        'msg' => 'Your record was successfully updated in the database.'
                    ]);

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
     * Deletes an existing TermsAndConditions model.
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
        $searchModel = new SearchTermsAndConditions();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();
        $getTermsConditions = TermsAndConditions::find()->all();

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getTermsConditions' => $getTermsConditions,
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => 'Success!', 'errType' => 'alert alert-success', 
                    'msg' => 'Your record was successfully deleted in the database.'
                ]);
    }

    /**
     * Finds the TermsAndConditions model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return TermsAndConditions the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TermsAndConditions::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $result = TermsAndConditions::find()->all();

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
             ->setCellValue('B1', 'Descriptions')
             ->setCellValue('C1', 'Date Created');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('C1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                    
                    $dateCreated = date('m-d-Y', strtotime($result_row['created_at']) );  

                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['descriptions']);
                    $objPHPExcel->getActiveSheet()->setCellValue('C'.$row,$dateCreated);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "TermsAndConditionsList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $result = TermsAndConditions::find()->all();
        $content = $this->renderPartial('_pdf', ['result' => $result]);

        $dompdf = new Dompdf();

        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('TermsAndConditionsList-' . date('m-d-Y'));
    }
}