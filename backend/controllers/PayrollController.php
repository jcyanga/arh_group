<?php

namespace backend\controllers;

use Yii;
use common\models\Payroll;
use common\models\SearchPayroll;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Dompdf\Dompdf;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;
/**
 * PayrollController implements the CRUD actions for Payroll model.
 */
class PayrollController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
        // $userRole = Role::find()->all();

        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Payroll'])->andWhere(['role_id' => $uRId ])->all();
            
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
     * Lists all Payroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchPayroll')['staff_id'])) {
            $getPayroll = $searchModel->searchStaffName(Yii::$app->request->get('SearchPayroll')['staff_id']);
        
        }else {
            $getPayroll = $searchModel->getPayrolls();

        }

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getPayroll' => $getPayroll, 
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => '', 
                    'errType' => '', 
                    'msg' => ''
        ]);
    }

    /**
     * Displays a single Payroll model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $searchModel = new SearchPayroll();
        $getPayroll = $searchModel->getPayrollById($id);

        return $this->render('view', [
                            'model' => $getPayroll,
                        ]);
    }

    /**
     * Creates a new Payroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Payroll();
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $result = $searchModel->getPayrollSameName(Yii::$app->request->post('Payroll') ['staff_id'], Yii::$app->request->post('Payroll') ['pay_date']);

            if( $result == 1 ) {
                return $this->render('create', [
                                'model' => $model, 
                                'errTypeHeader' => 'Warning!', 
                                'errType' => 'alert alert-warning', 
                                'msg' => 'You already enter an existing name, Please! Change the staff name or pay-date.']);
            }

            $model->pay_date = date('Y-m-d', strtotime(Yii::$app->request->post('Payroll')['pay_date']));

            if( $model->save() ) {
                $getPayroll = $searchModel->getPayrolls();

                return $this->render('index', [
                                'searchModel' => $searchModel, 
                                'getPayroll' => $getPayroll,
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
     * Updates an existing Payroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ( $model->load(Yii::$app->request->post()) ) {
            $model->pay_date = date('Y-m-d', strtotime(Yii::$app->request->post('Payroll')['pay_date']));
            
            if($model->save()) {
               
                $getPayroll = $searchModel->getPayrolls();

                return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getPayroll' => $getPayroll,
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
     * Deletes an existing Payroll model.
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
        $searchModel = new SearchPayroll();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();
        $getPayroll = $searchModel->getPayrolls();

        return $this->render('index', [
                    'searchModel' => $searchModel, 
                    'getPayroll' => $getPayroll,
                    'dataProvider' => $dataProvider, 
                    'errTypeHeader' => 'Success!', 'errType' => 'alert alert-success', 
                    'msg' => 'Your record was successfully deleted in the database.'
                ]);
    }

    /**
     * Finds the Payroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Payroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Payroll::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
