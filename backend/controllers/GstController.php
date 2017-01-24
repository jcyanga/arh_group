<?php

namespace backend\controllers;

use Yii;
use common\models\Gst;
use common\models\SearchGst;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use common\models\Role;
use common\models\UserPermission;

/**
 * GstController implements the CRUD actions for Gst model.
 */
class GstController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $userRoleArray = ArrayHelper::map(Role::find()->all(), 'id', 'role');
        // $userRole = Role::find()->all();

        foreach ( $userRoleArray as $uRId => $uRName ){ 
            $permission = UserPermission::find()->where(['controller' => 'Gst'])->andWhere(['role_id' => $uRId ])->all();
            
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
     * Lists all Gst models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new Gst();
        $searchModel = new SearchGst();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if( !empty(Yii::$app->request->get('SearchGst')['branch_id'])) {
                $getGst = $searchModel->searchBranchWithGst(Yii::$app->request->get('SearchGst')['branch_id']);

        }else {
                $getGst = $searchModel->getGsts();

        }

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getGst' => $getGst, 
                            'model' => $model, 
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => '', 
                            'errType' => '', 
                            'msg' => ''
                        ]);
    }

    /**
     * Displays a single Gst model.
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
     * Creates a new Gst model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Gst();
        $searchModel = new SearchGst();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if ($model->load(Yii::$app->request->post())) {
            $result = $searchModel->searchExistGst(Yii::$app->request->post('Gst') ['branch_id']);

            if( $result == 1 ) {
                return $this->render('create', [
                                        'model' => $model, 
                                        'errTypeHeader' => 'Warning!', 
                                        'errType' => 'alert alert-warning', 
                                        'msg' => 'You already enter an existing branch name, Please! Choose other branch name.'
                                    ]);
            }

            if( $model->save() ) {
                $getGst = $searchModel->getGsts();

                return $this->render('index', [
                                        'searchModel' => $searchModel, 
                                        'getGst' => $getGst,
                                        'dataProvider' => $dataProvider, 
                                        'errTypeHeader' => 'Success!', 
                                        'errType' => 'alert alert-success', 
                                        'msg' => 'Your record was successfully added in the database.'
                                    ]);

            }else {
                return $this->render('create', [
                                    'model' => $model, 
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
     * Updates an existing Gst model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Gst model.
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
        $model = new Gst();
        $searchModel = new SearchGst();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->findModel($id)->delete();
        $getGst = $searchModel->getGsts();

        return $this->render('index', [
                            'searchModel' => $searchModel, 
                            'getGst' => $getGst,
                            'dataProvider' => $dataProvider, 
                            'errTypeHeader' => 'Success!', 
                            'errType' => 'alert alert-success', 
                            'msg' => 'Your record was successfully deleted in the database.'
                        ]);
    }

    /**
     * Finds the Gst model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Gst the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Gst::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
