<?php

namespace backend\controllers;

use Yii;
use common\models\Role;
use common\models\SearchRole;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\UserPermission;
/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller
{
    public $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
       
        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Role'])->andWhere(['role_id' => $uRId ] )->all();
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchRole();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchRole')['role'])) {
                $getRole = $searchModel->searchRoleName(Yii::$app->request->get('SearchRole')['role']);

        }else {
                $getRole = Role::find()->where('id > 1')->andWhere(['status' => 1])->all();
        
        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getRole' => $getRole,
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
                ]);
    }

    /**
     * Displays a single Role model.
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
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Role();

        return $this->render('create', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    public function actionNew()
    {
        $model = new Role();  

        if ( Yii::$app->request->post() ) {   

            $model->role = Yii::$app->request->post('name');
            $model->created_at = date('Y-m-d H:i:s');
            $model->created_by = Yii::$app->user->identity->id;
            $model->status = 1;

            if($model->validate()) {
                $model->save();
                return json_encode(['message' => 'Your record was successfully added in the database.', 'status' => 'Success']);

            } else {
               return json_encode(['message' => $model->errors, 'status' => 'Error']);
            
            }
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        
        return $this->render('update', [
                            'model' => $model, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);  
    }

    public function actionEdit()
    {
        $model = $this->findModel(Yii::$app->request->post('id'));

        $model->role = Yii::$app->request->post('name');
        $model->created_at = date('Y-m-d H:i:s');
        $model->created_by = Yii::$app->user->identity->id;
        $model->status = 1;

        if($model->validate()) {
           $model->save();
           return json_encode(['message' => 'Your record was successfully updated in the database.', 'status' => 'Success']);

        } else {
           return json_encode(['message' => $model->errors, 'status' => 'Error']);
        
        }
    }

    /**
     * Deletes an existing Role model.
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
        $searchModel = new SearchRole();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $model = $this->findModel($id);
        $model->status = 0;
        $model->save();

        Yii::$app->getSession()->setFlash('success', 'Your record was successfully deleted in the database.');
        return $this->redirect(['index']);
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionExportExcel() 
    {
        $result = Role::find()->where('id > 1')->andWhere(['status' => 1])->all();;

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
             ->setCellValue('B1', 'Role');

             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($styleHeadingArray);
             $objPHPExcel->getActiveSheet()->getStyle('B1')->applyFromArray($styleHeadingArray);
                 
         $row=2;
                                
                foreach ($result as $result_row) {  
                        
                    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row,$result_row['id']); 
                    $objPHPExcel->getActiveSheet()->setCellValue('B'.$row,$result_row['role']);

                    $objPHPExcel->getActiveSheet()->getStyle('A')->applyFromArray($styleHeadingArray);
                    $row++ ;
                }
                        
        header('Content-Type: application/vnd.ms-excel');
        $filename = "User-RoleList-".date("m-d-Y").".xls";
        header('Content-Disposition: attachment;filename='.$filename);
        header('Cache-Control: max-age=0');
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');                

    }

    public function actionExportPdf() 
    {
        $result = Role::find()->where('id > 1')->andWhere(['status' => 1])->all();;
        $content = $this->renderPartial('_pdf', ['result' => $result]);
        
        $dompdf = new Dompdf();
        
        $dompdf->loadHtml($content);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('User-RoleList-' . date('m-d-Y'));       
    }
}
